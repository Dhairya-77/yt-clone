<main class="flex-1 p-6">
    <h2 class="text-3xl font-bold mb-6">Subscribed Channels</h2>

    <!-- Subscribed Channels List Container -->
    <div class="space-y-4">
    <?php
            // Array of subscribed channels with owner profile image and name
            $channels = [
                ["profile_img" => "req_img/owner1.png", "owner" => "Channel Owner 1"],
                ["profile_img" => "req_img/owner2.png", "owner" => "Channel Owner 2"],
                ["profile_img" => "req_img/owner3.png", "owner" => "Channel Owner 3"],
                ["profile_img" => "req_img/owner4.png", "owner" => "Channel Owner 4"],
                ["profile_img" => "req_img/owner5.png", "owner" => "Channel Owner 5"],
                // Add more channels as needed
            ];

            // Loop through each channel and generate HTML
            foreach ($channels as $channel) {
                echo '
                    <div class="flex items-center bg-purple-800 rounded-lg overflow-hidden shadow-lg p-4 space-x-4 hover:bg-purple-700 transition-colors duration-300">
                    <!-- Channel Owner Profile Image -->
                    <img src="' . $channel['profile_img'] . '" alt="' . $channel['owner'] . '" class="w-12 h-12 rounded-full">

                    <!-- Channel Owner Info -->
                    <div class="flex-1">
                        <h3 class="text-lg font-bold">' . $channel['owner'] . '</h3>
                    </div>

                    <!-- Unsubscribe Button -->
                    <form action="unsubscribe.php" method="POST">
                        <input type="hidden" name="channel_name" value="' . $channel['owner'] . '">
                        <button type="submit" class="hover:text-red-500 font-bold">Unsubscribe</button>
                    </form>
                </div>';
            }
        ?>
    </div>
</main>