<main class="flex-1 p-6">

    <h2 class="text-3xl font-bold mb-6">Home</h2>
        
    <!-- Video Grid Container -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
            // Video data array
            $videos = [
                ["src" => "videos//acha chhalta hu.mp4", "title" => "Video Title 1", "link" => "Dashboard.php?page=Watch_Area&?vid=null"],
                ["src" => "videos//triggu cry.mp4", "title" => "Video Title 2", "link" => "Dashboard.php?page=Watch_Area"],
                ["src" => "videos/video3.mp4", "title" => "Video Title 3", "link" => "Dashboard.php?page=Watch_Area"],
                ["src" => "videos/video4.mp4", "title" => "Video Title 4", "link" => "Dashboard.php?page=Watch_Area"],
                ["src" => "videos/video5.mp4", "title" => "Video Title 5", "link" => "Dashboard.php?page=Watch_Area"],
                ["src" => "videos/video6.mp4", "title" => "Video Title 6", "link" => "Dashboard.php?page=Watch_Area"],
                // Add more videos as needed
            ];

            // Loop through each video and generate HTML
            foreach ($videos as $video) {
                echo '
                <a href="' . $video['link'] . '" class="bg-purple-800 rounded-lg overflow-hidden shadow-lg cursor-pointer hover:bg-purple-700 transition-colors duration-300">
                    <video controls class="w-full h-48 object-cover">
                        <source src="' . $video['src'] . '" type="video/mp4">
                    </video>
                    <div class="p-4">
                        <h3 class="text-lg font-bold">' . $video['title'] . '</h3>
                    </div>
                </a>';
            }
        ?>
    </div>
</main>