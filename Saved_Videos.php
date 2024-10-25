<main class="flex-1 p-6">
    <h2 class="text-3xl font-bold mb-6">Saved Videoes</h2>

    <!-- Saved Video List Container -->
    <div class="space-y-4">
        <?php
            // Video data array with video source, title, and link
            $videos = [
                ["src" => "req_video/video1.mp4", "title" => "Saved Video 1", "link" => "video1.php"],
                ["src" => "req_video/video2.mp4", "title" => "Saved Video 2", "link" => "video2.php"],
                ["src" => "req_video/video3.mp4", "title" => "Saved Video 3", "link" => "video3.php"],
                ["src" => "req_video/video4.mp4", "title" => "Saved Video 4", "link" => "video4.php"],
                // Add more saved videos as needed
            ];

            // Loop through each video and generate HTML
            foreach ($videos as $video) {
                echo '
                <div class="flex items-center bg-purple-800 rounded-lg overflow-hidden shadow-lg p-4 space-x-4 hover:bg-purple-700 transition-colors duration-300">
                    <!-- Video Element -->
                    <a href="' . $video['link'] . '" class="flex-shrink-0">
                        <video controls class="w-32 h-20 object-cover rounded-lg">
                            <source src="' . $video['src'] . '" type="video/mp4">
                        </video>
                    </a>
                        
                    <!-- Video Info -->
                    <div class="flex-1 flex items-center justify-between">
                        <a href="' . $video['link'] . '" class="text-lg font-bold hover:underline">' . $video['title'] . '</a>
                            
                        <!-- Remove Button -->
                        <form action="remove_saved.php" method="POST">
                            <input type="hidden" name="video_id" value="' . $video['title'] . '">
                            <button type="submit" class="hover:text-red-500 font-bold">Remove from Saved</button>
                        </form>
                    </div>
                </div>';
            }
        ?>
    </div>
</main>