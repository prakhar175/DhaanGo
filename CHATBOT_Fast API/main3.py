# Required Libraries
#!pip install torch
#!pip install transformers
#!pip install langchain
#!pip install langchain-groq
#!pip install groq
#!pip install requests

GROQ_API_KEY = "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"

import os
import requests
from fastapi import FastAPI, Request, Form
from fastapi.responses import HTMLResponse
from fastapi.templating import Jinja2Templates
from groq import Groq

# Groq Client Initialization
client = Groq(api_key=GROQ_API_KEY)

# FastAPI Application
app = FastAPI()
templates = Jinja2Templates(directory="templates")

# Function to get geolocation based on IP address
def get_geolocation(ip=""):
    url = f"https://ipinfo.io/{ip}/json"
    response = requests.get(url)
    return response.json()

@app.get("/", response_class=HTMLResponse)
async def read_index(request: Request):
    return templates.TemplateResponse("index3.html", {"request": request})

@app.post("/", response_class=HTMLResponse)
async def handle_form(request: Request, location: str = Form(...), month: str = Form(...)):
    # Get geolocation data
    client_ip = request.client.host
    location_data = get_geolocation(client_ip)

    # Use the submitted location
    Location = location  # Use location from the form input
    Month = month  # Use month from the form input

    # Translation of Month from Hindi to English
    url = 'https://api.devnagri.com/machine-translation/v2/translate'
    data = {
        'key': 'devnagri_a52a6a788d8311ef972f4a279c6d377c',  # Replace with your actual API key
        'sentence': Month,
        'src_lang': 'hi',
        'dest_lang': 'en'
    }
    response = requests.post(url, data=data)
    ans = response.json()
    answer = ans["translated_text"]
    Month = answer

    # Soil Type Inquiry
    chat_completion = client.chat.completions.create(
        messages=[{"role": "user", "content": f"Given is the area: {Location}, Please tell what type of soil is present in this area."}],
        model="llama3-8b-8192",
    )
    Answer = chat_completion.choices[0].message.content

    # Soil Type Extraction
    chat_completion1 = client.chat.completions.create(
        messages=[{"role": "user", "content": f"Give me the name of the soil types from this whole paragraph- {Answer}. The output should be in the format of 'The soil type specified in the area is/are - output'"}],
        model="llama3-8b-8192",
    )
    Soil_Type = chat_completion1.choices[0].message.content

    # Crop Prediction
    chat_completion2 = client.chat.completions.create(
        messages=[{"role": "user", "content": f"From the given location {Location}, and {Soil_Type}, help me choose the top 3 crops to grow during the month of {Month}, where I can earn the most profit and the most yield. The answer should be concise and specific."}],
        model="llama3-8b-8192",
    )
    Answer = chat_completion2.choices[0].message.content

    # Crop Name Extraction
    chat_completion3 = client.chat.completions.create(
        messages=[{"role": "user", "content": f"Give me the name of the crops from this whole paragraph- {Answer}. Just give me the out crop name nothing else also give each crop name in next line with plain text"}],
        model="llama3-8b-8192",
    )
    Crop_Prediction = chat_completion3.choices[0].message.content

    # Translation of Crop Prediction from English to Hindi
    data = {
        'key': 'devnagri_a52a6a788d8311ef972f4a279c6d377c',  # Replace with your actual API key
        'sentence': Crop_Prediction,
        'src_lang': 'en',
        'dest_lang': 'hi'
    }
    response = requests.post(url, data=data)
    ans = response.json()
    answer = ans["translated_text"]
    
    print(Crop_Prediction)
    print(answer)

    # Return the HTML page with results
    return templates.TemplateResponse("index3.html", {"request": request, "location": Location, "month": Month, "crop_prediction": answer})

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="127.0.0.1", port=8000)
