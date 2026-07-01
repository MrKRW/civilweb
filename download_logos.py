import base64
import json
import urllib.request
import urllib.parse
import ssl

ssl._create_default_https_context = ssl._create_unverified_context

logos = [
    {"alt": "Mazanec", "url": "https://civilanka.com/uploads/logos/logo_6a3bad76eafe28.21349305.jpg"},
    {"alt": "EPIC", "url": "https://civilanka.com/uploads/logos/logo_6a3bad5a6c9a02.13187782.jpg"},
    {"alt": "Hosokawa Alpine", "url": "https://civilanka.com/uploads/logos/logo_6a3bad48c67e40.02405538.jpg"},
    {"alt": "Westport", "url": "https://civilanka.com/uploads/logos/logo_6a3bad35666e06.11957914.jpg"},
    {"alt": "Gems & Partner", "url": "https://civilanka.com/uploads/logos/logo_6a3bad27b9de38.76631544.png"},
    {"alt": "Intrafor", "url": "https://civilanka.com/uploads/logos/logo_6a3bad19e8dbb5.78825162.jpg"},
    {"alt": "Surewest", "url": "https://civilanka.com/uploads/logos/logo_6a3bad0c67e525.84899538.png"},
    {"alt": "mindstudio", "url": "https://civilanka.com/uploads/logos/logo_6a3bacf3aa2e46.12771378.png"},
    {"alt": "RA international", "url": "https://civilanka.com/uploads/logos/logo_6a3bac7a5a69e5.79779457.png"},
    {"alt": "Vykres", "url": "https://civilanka.com/uploads/logos/logo_6a3bac6b237270.37936484.jpg"},
    {"alt": "Metro Tow Trucks", "url": "https://civilanka.com/uploads/logos/logo_6a3bac5bd72539.14685798.jpg"},
    {"alt": "H&B Steel", "url": "https://civilanka.com/uploads/logos/logo_6a43b3ce4036a9.00932853.png"},
    {"alt": "BEHMER", "url": "https://civilanka.com/uploads/logos/logo_6a3bac11af5993.43430116.jpg"},
    {"alt": "BCS", "url": "https://civilanka.com/uploads/logos/logo_6a3babfba214c6.16496199.jpg"},
    {"alt": "Swan Li", "url": "https://civilanka.com/uploads/logos/logo_6a3babebbdf290.27183116.png"},
    {"alt": "Apex", "url": "https://civilanka.com/uploads/logos/logo_6a3babdde8a177.51262754.png"},
    {"alt": "Urth.", "url": "https://civilanka.com/uploads/logos/logo_6a3bab197c6bd1.36913317.png"},
    {"alt": "Modpadz", "url": "https://civilanka.com/uploads/logos/logo_6a3bab53950272.13239386.png"},
    {"alt": "BOI", "url": "https://civilanka.com/uploads/logos/logo_6a3baa868d1380.46961839.png"},
    {"alt": "Natex", "url": "https://civilanka.com/uploads/logos/logo_6a3baa7d484fb5.94758977.png"},
    {"alt": "Australian HSRA", "url": "https://civilanka.com/uploads/logos/logo_6a3ba0d45d4b11.99581543.png"},
    {"alt": "SLA", "url": "https://civilanka.com/uploads/logos/logo_6a3ba0bae18230.48420255.png"},
    {"alt": "Hga", "url": "https://civilanka.com/uploads/logos/logo_6a3ba0aee35e15.23455713.png"},
    {"alt": "Timmons Group", "url": "https://civilanka.com/uploads/logos/logo_6a3ba00d6663c2.29865339.png"}
]

base64_mapping = {}
headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'}

for logo in logos:
    url = logo['url']
    if url.startswith('/'):
        url = 'https://civilanka.com' + url
    try:
        req = urllib.request.Request(url, headers=headers)
        with urllib.request.urlopen(req) as response:
            data = response.read()
            ext = url.split('.')[-1].lower()
            if ext == 'jpg': ext = 'jpeg'
            base64_data = base64.b64encode(data).decode('utf-8')
            base64_mapping[logo['alt']] = f"data:image/{ext};base64,{base64_data}"
            print(f"Successfully processed {logo['alt']}")
    except Exception as e:
        print(f"Failed to process {logo['alt']}: {e}")

with open('logos_base64.json', 'w') as f:
    json.dump(base64_mapping, f, indent=4)
print("Saved mapping to logos_base64.json")
