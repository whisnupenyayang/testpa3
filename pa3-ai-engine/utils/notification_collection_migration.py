# Migration script to create a new MongoDB collection for notifications
from pymongo import MongoClient

client = MongoClient('mongodb://localhost:27017/')
db = client['db_konselor']  # Ganti dengan nama database Anda

# Membuat collection baru untuk notifikasi jika belum ada
def create_notification_collection():
    if 'notifications' not in db.list_collection_names():
        db.create_collection('notifications')
        print('Collection "notifications" created.')
    else:
        print('Collection "notifications" already exists.')

if __name__ == '__main__':
    create_notification_collection()
