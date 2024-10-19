

#!pip install torch
#!pip install transformers
##!pip install langchain
##!pip install langchain-groq

#!pip install groq

GROQ_API_KEY="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"

import os

from groq import Groq

client = Groq(
    api_key=GROQ_API_KEY,
)

Location = input("Give Location ") #Qurani Input De
Month = input("वह महीना बताएं जिस पर आप अपनी फसल उगाना चाहते हैं ") 

url = 'https://api.devnagri.com/machine-translation/v2/translate'

# Form data
data = {
    'key': 'devnagri_a52a6a788d8311ef972f4a279c6d377c',  # Replace with your actual API key
    'sentence': Month,
    'src_lang': 'hi',
    'dest_lang': 'en'
}

# Make POST request
response = requests.post(url, data=data)

ans = response.json()
answer = ans["translated_text"]
Month = answer




chat_completion = client.chat.completions.create(
    messages=[
        {
            "role": "user",
            "content": f"Given is the area: {Location}, Please tell what type of soil is present in this area.",
        }
    ],
    model="llama3-8b-8192",
)

Answer = chat_completion.choices[0].message.content

client1 = Groq(
    api_key=GROQ_API_KEY,
)

Query = Answer


chat_completion1 = client1.chat.completions.create(
    messages=[
        {
            "role": "user",
            "content": f"Give me the name of the soil types from this whole paragraph- {Query}. The output should be in the format of 'The soil type specified in the area is/are - output'",
        }
    ],
    model="llama3-8b-8192",
)

Soil_Type = chat_completion1.choices[0].message.content

client2 = Groq(
    api_key=GROQ_API_KEY,
)

Query = Location


chat_completion2 = client2.chat.completions.create(
    messages=[
        {
            "role": "user",
            "content": f"From the given location {Query}, and {Soil_Type}, help me choose the top 3 crops to grow during the month of {Month}, where I can earn the most profit and the most yield. The answer should be consise and specific.",
        }
    ],
    model="llama3-8b-8192",
)

Answer = chat_completion2.choices[0].message.content

client3 = Groq(
    api_key=GROQ_API_KEY,
)

Query = Answer


chat_completion3 = client3.chat.completions.create(
    messages=[
        {
            "role": "user",
            "content": f"Give me the name of the crops from this whole paragraph- {Query}. The output should be in the format of 'The crops specified in the area is - output', and only plain text, no headings or subheadings. ",
        }
    ],
    model="llama3-8b-8192",
)

Crop_Prediction= chat_completion3.choices[0].message.content

url = 'https://api.devnagri.com/machine-translation/v2/translate'

# Form data
data = {
    'key': 'devnagri_a52a6a788d8311ef972f4a279c6d377c',  # Replace with your actual API key
    'sentence': Crop_Prediction,
    'src_lang': 'en',
    'dest_lang': 'hi'
}

# Make POST request
response = requests.post(url, data=data)

ans = response.json()
answer = ans["translated_text"]
print(Crop_Prediction)
print(answer)

import requests
import io
import pygame
import time
from pygame import mixer
import tempfile
import os
import sounddevice as sd
import soundfile as sf
import numpy as np

def text_to_speech_direct(text):
    API_KEY = "sk_960d5837e76361493bce03b2d3ad9f5dcde11abe20ca69b3"
    VOICE_ID = "21m00Tcm4TlvDq8ikWAM"

    url = f"https://api.elevenlabs.io/v1/text-to-speech/{VOICE_ID}"

    headers = {
        "Accept": "audio/mpeg",
        "Content-Type": "application/json",
        "xi-api-key": API_KEY
    }

    data = {
        "text": text,
        "model_id": "eleven_multilingual_v2",
        "voice_settings": {
            "stability": 1.0,
            "similarity_boost": 0.75
        }
    }

    try:
        print("Converting text to speech...")
        response = requests.post(url, json=data, headers=headers)

        if response.status_code == 200:
            print("✓ Conversion successful!")
            return response.content
        else:
            print(f"✗ Error: {response.status_code}")
            return None

    except Exception as e:
        print(f"✗ An error occurred: {str(e)}")
        return None

def play_audio_pygame(audio_data):
    try:

        pygame.mixer.init()


        with tempfile.NamedTemporaryFile(delete=False, suffix='.mp3') as temp_audio:
            temp_audio.write(audio_data)
            temp_audio_path = temp_audio.name


        pygame.mixer.music.load(temp_audio_path)
        pygame.mixer.music.play()

        while pygame.mixer.music.get_busy():
            time.sleep(0.1)

        pygame.mixer.music.stop()
        pygame.mixer.quit()
        os.remove(temp_audio_path)

    except Exception as e:
        print(f"Error playing audio: {str(e)}")


def main():
    hindi_text = answer

    audio_data = text_to_speech_direct(hindi_text)

    if audio_data:
        print("\nPlaying audio using pygame...")
        play_audio_pygame(audio_data)

if __name__ == "__main__":
    main()

