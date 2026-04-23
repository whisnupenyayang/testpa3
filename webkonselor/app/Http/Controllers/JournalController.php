<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JournalController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|exists:students,nim',
            'journal_text' => 'required|string|max:1000',
            'emotion_id' => 'required|integer|exists:emotions,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $nim = $request->input('nim');
        $journalText = $request->input('journal_text');
        $emotionId = $request->input('emotion_id');
        $emotionLabel = $request->input('emotion_label');

        try {
            $response = Http::timeout(30)->post('http://127.0.0.1:8001/api/generate-popup', [
                'nim' => $nim,
                'journal_text' => $journalText,
                'emotion_label' => $emotionLabel
            ]);

            if ($response->successful()) {
                $aiReply = $response->json()['reply'] ?? 'AI tidak memberikan balasan.';

                DB::table('journal_entries')->insert([
                    'nim' => $nim,
                    'emotion_id' => $emotionId,
                    'journal_text' => $journalText,
                    'ai_reply' => $aiReply,
                    'date' => date('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json([
                    'message' => 'Jurnal berhasil disimpan!',
                    'popup_ai' => $aiReply
                ]);
            } else {
                DB::table('journal_entries')->insert([
                    'nim' => $nim,
                    'emotion_id' => $emotionId,
                    'journal_text' => $journalText,
                    'ai_reply' => null,
                    'date' => date('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json([
                    'message' => 'Jurnal disimpan, tapi AI sedang sibuk.',
                    'popup_ai' => 'AI tidak tersedia saat ini.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}