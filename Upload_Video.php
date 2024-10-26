<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-950 flex items-center justify-center min-h-screen">
    <div class="bg-purple-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-yellow-400 font-semibold text-center text-3xl mb-6">Upload Video</h2>

        <!-- Video Player -->
        <div class="mb-6">
            <video id="videoPlayer" controls class="w-full h-48 bg-black rounded-md">
                <source src="" type="video/mp4"> <!-- Placeholder for video source -->
            </video>
        </div>

        <!-- Select File -->
        <div class="mb-4">
            <input type="file" id="videoFile" name="video_file" accept="video/*" class="w-full bg-purple-700 text-yellow-400 rounded-md border-2 border-yellow-500 focus:outline-none focus:border-yellow-300" onchange="loadVideo(event)">
        </div>

        <!-- Video Title -->
        <div class="mb-6">
            <label for="videoTitle" class="block text-yellow-400">Video Title</label>
            <input type="text" id="videoTitle" name="video_title" placeholder="Enter Video Title" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
        </div>

        <!-- Upload Button -->
        <button type="submit" name="upload_btn" class="w-full bg-yellow-400 text-purple-950 py-2 rounded-md font-semibold hover:bg-yellow-300 transition duration-300">
            Upload Video
        </button>
    </div>

    <script>
        // Load the selected video file into the video player
        function loadVideo(event) {
            const videoFile = event.target.files[0];
            const videoPlayer = document.getElementById("videoPlayer");

            if (videoFile) {
                const videoURL = URL.createObjectURL(videoFile);
                videoPlayer.src = videoURL;
                videoPlayer.play();  // Optional: Auto-play the selected video
            }
        }
    </script>
</body>
</html>
