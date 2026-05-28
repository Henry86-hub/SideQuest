<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Quest;
use App\Models\Announcement;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Admin, Officer, Members)
        $admin = User::create([
            'name' => 'Guild Master Alden',
            'email' => 'admin@guild.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'level' => 99,
            'exp' => 0,
        ]);

        $officer = User::create([
            'name' => 'Officer Varis',
            'email' => 'officer@guild.com',
            'password' => Hash::make('password'),
            'role' => 'officer',
            'level' => 45,
            'exp' => 0,
        ]);

        $warrior = User::create([
            'name' => 'Erick the Warrior',
            'email' => 'erick@guild.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'level' => 6,
            'exp' => 40,
        ]);

        $mage = User::create([
            'name' => 'Lumina the Mage',
            'email' => 'lumina@guild.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'level' => 18,
            'exp' => 120,
        ]);

        $rogue = User::create([
            'name' => 'Kaelen the Rogue',
            'email' => 'kaelen@guild.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'level' => 3,
            'exp' => 10,
        ]);

        $cleric = User::create([
            'name' => 'Sera the Cleric',
            'email' => 'sera@guild.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'level' => 28,
            'exp' => 180,
        ]);

        // 2. Seed Announcements
        Announcement::create([
            'title' => '🏰 Annual Adventurers Festival!',
            'content' => 'Attention all guild members! The annual Adventurers Festival will take place next week in the main plaza. Prepare your finest gear and share your tales of glory. Special double EXP quests will be posted!',
        ]);

        Announcement::create([
            'title' => '⚠️ WARNING: High Threat Level Monster Spotted!',
            'content' => 'A dangerous Chimera has been spotted wandering near the Whispering Woods. We advise all members below B-Rank (Level 30) to steer clear of the area. Active quest is currently being prepared for high-rank adventurers.',
        ]);

        Announcement::create([
            'title' => '🛠️ Blacksmith Shop Guild Discount',
            'content' => 'Thanks to our new partnership with Alaric\'s Forge, all registered SideQuest members now receive a 15% discount on weapon upgrades and armor repairs. Present your Guild ID card at purchase!',
        ]);

        // 3. Seed Quests
        // Available Quests
        Quest::create([
            'title' => 'Find Lily\'s Lost Black Cat',
            'description' => 'A sweet little girl named Lily lost her black kitten "Shadow" near the southern farmlands. It has a blue collar with a small golden bell. It is harmless but very fast. Please bring it back safely to its owner.',
            'reward' => '50 Gold Coins & 3x Home Cooked Apple Pies',
            'difficulty' => 'F',
            'status' => 'available',
            'deadline' => Carbon::now()->addDays(3),
        ]);

        Quest::create([
            'title' => 'Harvest Sweet Glow-Mushrooms',
            'description' => 'The Guild apothecary requires 10 fresh Sweet Glow-Mushrooms found inside the Echoing Caves. They only emit light in deep darkness. Handle with soft gloves as they are very fragile.',
            'reward' => '120 Gold Coins & 2x Lesser Mana Potions',
            'difficulty' => 'E',
            'status' => 'available',
            'deadline' => Carbon::now()->addDays(5),
        ]);

        Quest::create([
            'title' => 'Clear the Slime Infestation',
            'description' => 'Slimes have been blocking the water wells of the northern vegetable farms. Exterminate 15 Slimes and secure the water source. Bring back slime cores as proof.',
            'reward' => '250 Gold Coins & 1x Stamina Elixir',
            'difficulty' => 'D',
            'status' => 'available',
            'deadline' => Carbon::now()->addDays(2),
        ]);

        Quest::create([
            'title' => 'Banish the Crypt Skeleton Scouts',
            'description' => 'Local villagers reported glowing red eyes inside the Old Abbey ruins. Exterminate 8 Skeleton Scouts that have risen from their graves. They carry rusty swords but are vulnerable to holy and blunt weapons.',
            'reward' => '500 Gold Coins & 1x Silver Shield',
            'difficulty' => 'C',
            'status' => 'available',
            'deadline' => Carbon::now()->addDays(4),
        ]);

        Quest::create([
            'title' => 'Exterminate Goblin Chieftain "Gorgon"',
            'description' => 'A raiding band of goblins led by Chieftain Gorgon has set up camp in the Whispering Woods. They have been attacking merchant caravans. Slay Chieftain Gorgon and retrieve his iron warhorn.',
            'reward' => '1,200 Gold Coins & 1x Berserker Ring',
            'difficulty' => 'B',
            'status' => 'available',
            'deadline' => Carbon::now()->addDays(6),
        ]);

        Quest::create([
            'title' => 'Slay the Ancient Crimson Dragon',
            'description' => 'The terrible Crimson Dragon "Ignis" has awoken in the summit of Vulkan\'s Peak. It has scorched multiple border villages. We require a high-tier party to storm its nest and slay it. Extreme caution: Dragon fire ignores normal physical shields!',
            'reward' => '15,000 Gold Coins, 1x Dragon Scale Armor & Mythic Badge of Valor',
            'difficulty' => 'S',
            'status' => 'available',
            'deadline' => Carbon::now()->addDays(15),
        ]);

        // In Progress / Claimed Quests
        Quest::create([
            'title' => 'Guard Merchant Caravan to Capital',
            'description' => 'A wealthy merchant caravan carrying silk, spices, and magic crystals requires escort protection from thieves and wild monsters along the High Ridge road. Minimum Level 15 recommended.',
            'reward' => '800 Gold Coins & Guild Merits',
            'difficulty' => 'D',
            'status' => 'in_progress',
            'deadline' => Carbon::now()->addDays(4),
            'assigned_to' => $warrior->id,
        ]);

        Quest::create([
            'title' => 'Subdue the Raging Forest Golem',
            'description' => 'A giant Golem made of mossy stone and ancient oak is rampaging in the Sacred Grove, disrupting the forest spirits. Discover its core weak spot, pacify it, and restore the grove\'s magical barrier.',
            'reward' => '2,500 Gold Coins & 1x Ring of Earth Attunement',
            'difficulty' => 'A',
            'status' => 'in_progress',
            'deadline' => Carbon::now()->addDays(7),
            'assigned_to' => $mage->id,
        ]);

        // Under Review / Submitted Quests
        $underReviewQuest = Quest::create([
            'title' => 'Investigate Haunted Manor in Oakhaven',
            'description' => 'Strange noises and ghostly lights have been emanating from the abandoned Oakhaven Manor. Map all rooms, locate the source of the curse, and cleanse the malicious spirits if possible.',
            'reward' => '1,500 Gold Coins & 1x Ghost-Slayer Amulet',
            'difficulty' => 'B',
            'status' => 'under_review',
            'deadline' => Carbon::now()->addDays(3),
            'assigned_to' => $cleric->id,
        ]);

        // Seed a pending submission for this under_review quest
        \App\Models\Submission::create([
            'quest_id' => $underReviewQuest->id,
            'user_id' => $cleric->id,
            'file' => 'submissions/oakhaven_manor_report.pdf',
            'note' => 'I have successfully mapped the manor. The hauntings were caused by an ancient cursed music box in the attic. I have sealed the box with holy runes. The manor is now safe, and the lingering spirits have been pacified. See my attached inspection report.',
            'status' => 'pending',
        ]);

        // Completed Quests
        $completedQuest1 = Quest::create([
            'title' => 'Deliver Rare Herbs to Guild Doctor',
            'description' => 'Deliver freshly picked Sun-dappled Leaves to the guild infirmary. The leaves decay fast, so speed is critical.',
            'reward' => '80 Gold Coins',
            'difficulty' => 'F',
            'status' => 'completed',
            'deadline' => Carbon::now()->subDays(1),
            'assigned_to' => $rogue->id,
        ]);

        \App\Models\Submission::create([
            'quest_id' => $completedQuest1->id,
            'user_id' => $rogue->id,
            'file' => 'submissions/herbs_delivery.jpg',
            'note' => 'Delivered to Doctor Beatrice. She confirmed they were in perfect condition!',
            'status' => 'approved',
            'feedback' => 'Excellent work on the fast delivery. Doctor Beatrice was highly satisfied.',
        ]);
    }
}
