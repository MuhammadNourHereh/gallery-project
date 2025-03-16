export const fileToBase64 = (file) => {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();

        // Define what happens when the file is read
        reader.onloadend = () => {
            resolve(reader.result); // The result will be a Base64 string
        };

        // Define what happens if there is an error reading the file
        reader.onerror = (error) => {
            reject(error);
        };

        // Read the file as a data URL (Base64)
        reader.readAsDataURL(file);
    });
}