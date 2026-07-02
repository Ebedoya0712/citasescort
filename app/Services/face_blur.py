import cv2
import os
import sys

def blur_faces(image_path):
    if not os.path.exists(image_path):
        print(f"Error: File {image_path} does not exist.")
        return False
        
    # Read the image
    img = cv2.imread(image_path)
    if img is None:
        print("Error: Could not read image.")
        return False
        
    # Load the Haar Cascades for face detection
    frontal_cascade_path = os.path.join(cv2.data.haarcascades, "haarcascade_frontalface_default.xml")
    profile_cascade_path = os.path.join(cv2.data.haarcascades, "haarcascade_profileface.xml")
    
    frontal_cascade = cv2.CascadeClassifier(frontal_cascade_path)
    profile_cascade = cv2.CascadeClassifier(profile_cascade_path)
    
    if frontal_cascade.empty() or profile_cascade.empty():
        print("Error: Could not load Haar cascades.")
        return False
        
    # Convert image to grayscale for detection
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    
    # Detect frontal faces
    faces_frontal = frontal_cascade.detectMultiScale(
        gray,
        scaleFactor=1.08,
        minNeighbors=4,
        minSize=(30, 30)
    )
    
    # Detect profile (side-view) faces
    faces_profile = profile_cascade.detectMultiScale(
        gray,
        scaleFactor=1.08,
        minNeighbors=4,
        minSize=(30, 30)
    )
    
    # Merge both face lists
    faces = []
    if len(faces_frontal) > 0:
        faces.extend(faces_frontal)
    if len(faces_profile) > 0:
        for f in faces_profile:
            # Avoid duplicating a face if it was already detected by the frontal cascade
            is_duplicate = False
            for ff in faces_frontal:
                # Check overlap
                if abs(f[0] - ff[0]) < f[2] * 0.5 and abs(f[1] - ff[1]) < f[3] * 0.5:
                    is_duplicate = True
                    break
            if not is_duplicate:
                faces.append(f)
    
    if len(faces) == 0:
        print("No faces detected.")
        return False
        
    print(f"Detected {len(faces)} faces.")
    
    # Process each face detected
    for (x, y, w, h) in faces:
        # Expand region slightly to ensure full face (including forehead and chin) is covered
        offset_y = int(h * 0.15)
        offset_x = int(w * 0.1)
        
        y1 = max(0, y - offset_y)
        y2 = min(img.shape[0], y + h + offset_y)
        x1 = max(0, x - offset_x)
        x2 = min(img.shape[1], x + w + offset_x)
        
        fw = x2 - x1
        fh = y2 - y1
        
        if fw <= 0 or fh <= 0:
            continue
            
        # Get face Region of Interest
        face_roi = img[y1:y2, x1:x2]
        
        # Super Heavy Smooth Blur: Downscale to a tiny size, blur, and scale back up smoothly
        small_w = max(8, int(fw * 0.08))  # Shrink to 8% of original size
        small_h = max(8, int(fh * 0.08))
        
        small = cv2.resize(face_roi, (small_w, small_h), interpolation=cv2.INTER_AREA)
        blurred_small = cv2.GaussianBlur(small, (5, 5), 0)
        blurred_face = cv2.resize(blurred_small, (fw, fh), interpolation=cv2.INTER_LINEAR)
        
        # Place the blurred face back into the main image
        img[y1:y2, x1:x2] = blurred_face
        
    # Overwrite the original image
    cv2.imwrite(image_path, img)
    print("Success: Blurred and saved.")
    return True

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Usage: python face_blur.py <image_path>")
        sys.exit(1)
    blur_faces(sys.argv[1])
