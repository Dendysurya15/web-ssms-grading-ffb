<?php

namespace Database\Factories;

use App\Models\Grading;
use Illuminate\Database\Eloquent\Factories\Factory;

class GradingFactory extends Factory
{
    protected $model = Grading::class;

    public function definition()
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomAlphabet1 = $alphabet[$this->faker->numberBetween(0, 25)];
        $randomAlphabet2 = $alphabet[$this->faker->numberBetween(0, 25)];
        $randomNumber = $this->faker->numberBetween(100, 300); // Generate a random number between 100 and 300

        $no_tiket = $randomAlphabet1 . $randomAlphabet2 . '/' . $randomNumber;

        // Generate a random datetime within a specific range (e.g., current month)
        $waktu_mulai = $this->faker->dateTimeThisMonth;

        // Create a new datetime instance with the same date but 30 minutes later
        $waktu_selesai = $waktu_mulai->modify('+30 minutes');

        return [
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'mill_id' => $this->faker->randomElement([1, 2, 3]),
            'no_tiket' => $no_tiket,
            'no_plat' => $randomAlphabet1 . $randomAlphabet2 . $randomNumber,
            'nama_driver' => $this->faker->name(),
            'bisnis_unit' => $this->faker->randomElement(['SLE', 'RGE', 'RDE', 'KNE', 'PLE', 'UPE', 'SYE', 'KDE', 'SGE', 'BKE', 'NBE', 'BGE']),
            'divisi' => $this->faker->randomElement(['OA', 'OB', 'OC']),
            'blok' => $randomAlphabet1 . $randomAlphabet2 . $randomNumber,
            'status' => $this->faker->randomElement(['Eksternal', 'Inti']),
            'ripe' => $randomNumber,
            'unripe' => $randomNumber,
            'overripe' => $randomNumber,
            'empty_bunch' => $randomNumber,
            'abnormal' => $randomNumber,
            'kastrasi' => $randomNumber,
            'tp' => $randomNumber
        ];
    }
}
