import os
from pymongo import MongoClient
from pymongo.server_api import ServerApi
from dotenv import load_dotenv

# Load environment variables from .env file
load_dotenv(dotenv_path="webkonselor/.env")

# Get MongoDB URI from environment variables
uri = os.getenv("DB_URI")

if not uri:
    print("Error: DB_URI not found in environment variables.")
    exit(1)

print(f"Attempting to connect to MongoDB using URI: {uri[:15]}...{uri[-10:]}")

# Create a new client and connect to the server
client = MongoClient(uri, server_api=ServerApi('1'))

try:
    # Send a ping to confirm a successful connection
    client.admin.command('ping')
    print("Pinged your deployment. You successfully connected to MongoDB!")
    
    # Let's check databases and collections
    db_name = uri.split('.net/')[1].split('?')[0] if '?retryWrites' in uri else "monitoring"
    print(f"\nChecking database: {db_name}")
    db = client[db_name]
    
    collections = db.list_collection_names()
    print(f"Collections found: {collections}")
    
except Exception as e:
    print(f"An error occurred: {e}")
