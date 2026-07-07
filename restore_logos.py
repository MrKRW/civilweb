import json
import base64
import os
import re

# Read the base64 encoded logos
with open('logos_base64.json', 'r') as f:
    base64_data = json.load(f)

# Read the python file to map alt text to original filenames
with open('download_logos.py', 'r') as f:
    py_content = f.read()

# Extract URLs
urls = re.findall(r'"url":\s*"(.*?)"', py_content)
alts = re.findall(r'"alt":\s*"(.*?)"', py_content)

mapping = dict(zip(alts, urls))

os.makedirs('uploads/logos', exist_ok=True)

restored = 0
for alt, url in mapping.items():
    if alt in base64_data:
        # Get original filename from URL
        filename = url.split('/')[-1]
        
        # Get base64 string without the data uri prefix
        b64_string = base64_data[alt].split(',')[1]
        
        # Write to file
        file_path = os.path.join('uploads/logos', filename)
        with open(file_path, 'wb') as img_file:
            img_file.write(base64.b64decode(b64_string))
        print(f"Restored {filename}")
        restored += 1

print(f"\nSuccessfully restored {restored} original logo files to uploads/logos/")
print("You can now upload the contents of the 'uploads/logos/' folder to your Hostinger server using File Manager or FTP.")
