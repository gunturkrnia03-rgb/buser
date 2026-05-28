<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'content' => 'BREAKING: Drinking hot lemon water every morning completely cures all viral infections within 24 hours! Share this to save lives!',
            'author_name' => 'Health Tips Daily',
            'is_hoax' => true,
            'explanation' => 'While lemon water is healthy, there is no scientific evidence that it cures all viral infections, let alone in 24 hours. This is a common health myth.',
            'source_link' => 'https://www.who.int/emergencies/diseases/novel-coronavirus-2019/advice-for-public/myth-busters',
            'category' => 'Health',
        ]);

        Post::create([
            'content' => 'The government has officially announced a new tax deduction for students working part-time. Check the official portal for details.',
            'author_name' => 'News Portal',
            'is_hoax' => false,
            'explanation' => 'This is factual information often shared by official government news channels.',
            'source_link' => 'https://www.gov.uk/student-jobs-and-tax',
            'category' => 'Politics',
        ]);

        Post::create([
            'content' => 'URGENT: Your bank account will be suspended if you do not click this link and verify your credentials immediately: http://bit.ly/fake-bank-verify',
            'author_name' => 'Bank Security Alert',
            'is_hoax' => true,
            'explanation' => 'This is a classic phishing attempt. Banks never ask for sensitive credentials via a link in a message.',
            'source_link' => 'https://www.ncsc.gov.uk/guidance/phishing',
            'category' => 'Security',
        ]);

        Post::create([
            'content' => 'NASA recently discovered a new planet that could potentially support life, located in the habitable zone of its star.',
            'author_name' => 'Science Journal',
            'is_hoax' => false,
            'explanation' => 'NASA frequently discovers exoplanets in habitable zones, such as the TRAPPIST-1 system.',
            'source_link' => 'https://exoplanets.nasa.gov/',
            'category' => 'Science',
        ]);
    }
}
