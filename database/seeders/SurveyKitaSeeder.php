<?php

namespace Database\Seeders;

use App\Models\EvaluationForm;
use App\Models\EvaluationPeriod;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\Response as EvaluationResponse;
use App\Models\ResponseAnswer;
use App\Models\Student;
use App\Models\User;
use App\Services\NimParser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SurveyKitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parser = new NimParser;

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@universitasmulia.ac.id'],
            [
                'name' => 'Administrator SurveyKita',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        $students = collect([
            ['nim' => '2311032', 'name' => 'Aulia Rahmawati', 'class_name' => 'IF-23A'],
            ['nim' => '2312045', 'name' => 'Bagas Pratama', 'class_name' => 'TI-23A'],
            ['nim' => '2313056', 'name' => 'Citra Maharani', 'class_name' => 'SI-23A'],
            ['nim' => '2321078', 'name' => 'Dimas Saputra', 'class_name' => 'AK-23A'],
            ['nim' => '2322091', 'name' => 'Eka Lestari', 'class_name' => 'MN-23A'],
            ['nim' => '2333014', 'name' => 'Fajar Nugroho', 'class_name' => 'FA-23A'],
            ['nim' => '2351025', 'name' => 'Gita Permatasari', 'class_name' => 'TI-23B'],
            ['nim' => '2353036', 'name' => 'Hendra Wijaya', 'class_name' => 'TP-23A'],
        ])->map(function (array $data) use ($parser): Student {
            $parsed = $parser->parse($data['nim']);

            $user = User::query()->updateOrCreate(
                ['email' => $data['nim'].'@students.universitasmulia.ac.id'],
                [
                    'name' => $data['name'],
                    'role' => 'mahasiswa',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
            );

            return Student::query()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => $data['nim'],
                    'name' => $data['name'],
                    'program_code' => $parsed['program_code'],
                    'study_program' => $parsed['study_program'],
                    'enrollment_year' => $parsed['enrollment_year'],
                    'sequence_number' => $parsed['sequence_number'],
                    'class_name' => $data['class_name'],
                ],
            );
        });

        $currentPeriod = EvaluationPeriod::query()->updateOrCreate(
            ['name' => 'Evaluasi Kepuasan Mahasiswa Semester Genap 2025/2026'],
            [
                'semester' => 'Genap',
                'academic_year' => '2025/2026',
                'start_date' => now()->subDays(7)->toDateString(),
                'end_date' => now()->addDays(21)->toDateString(),
                'is_active' => true,
            ],
        );

        $previousPeriod = EvaluationPeriod::query()->updateOrCreate(
            ['name' => 'Evaluasi Kepuasan Mahasiswa Semester Ganjil 2025/2026'],
            [
                'semester' => 'Ganjil',
                'academic_year' => '2025/2026',
                'start_date' => now()->subMonths(5)->toDateString(),
                'end_date' => now()->subMonths(4)->toDateString(),
                'is_active' => false,
            ],
        );

        $categories = collect([
            'layanan_akademik' => ['name' => 'Layanan Akademik', 'description' => 'Evaluasi layanan akademik program studi.'],
            'pembelajaran' => ['name' => 'Pembelajaran', 'description' => 'Evaluasi kualitas pembelajaran dan perkuliahan.'],
            'fasilitas' => ['name' => 'Fasilitas', 'description' => 'Evaluasi fasilitas pendukung kegiatan akademik.'],
            'administrasi' => ['name' => 'Administrasi', 'description' => 'Evaluasi layanan administrasi akademik.'],
            'kepuasan_umum' => ['name' => 'Kepuasan Umum', 'description' => 'Evaluasi kepuasan umum mahasiswa.'],
        ])->mapWithKeys(fn (array $category, string $key): array => [
            $key => QuestionCategory::query()->updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']],
            ),
        ]);

        $forms = collect([
            [
                'period' => $currentPeriod,
                'title' => 'Evaluasi Layanan Akademik Program Studi',
                'description' => 'Form evaluasi kepuasan mahasiswa terhadap layanan akademik program studi.',
                'target_type' => 'layanan_akademik',
                'is_active' => true,
                'questions' => [
                    ['category' => 'layanan_akademik', 'text' => 'Informasi jadwal perkuliahan disampaikan dengan jelas dan tepat waktu.'],
                    ['category' => 'layanan_akademik', 'text' => 'Dosen wali atau pembimbing akademik mudah dihubungi saat dibutuhkan.'],
                    ['category' => 'administrasi', 'text' => 'Proses pengisian KRS berjalan lancar dan mudah dipahami.'],
                    ['category' => 'administrasi', 'text' => 'Petugas akademik memberikan pelayanan yang ramah dan solutif.'],
                    ['category' => 'kepuasan_umum', 'text' => 'Secara umum saya puas terhadap layanan akademik program studi.'],
                ],
            ],
            [
                'period' => $currentPeriod,
                'title' => 'Evaluasi Pembelajaran Semester Berjalan',
                'description' => 'Form evaluasi kepuasan mahasiswa terhadap proses pembelajaran.',
                'target_type' => 'pembelajaran',
                'is_active' => true,
                'questions' => [
                    ['category' => 'pembelajaran', 'text' => 'Dosen menjelaskan materi kuliah dengan sistematis dan mudah dipahami.'],
                    ['category' => 'pembelajaran', 'text' => 'Metode pembelajaran mendorong mahasiswa aktif berdiskusi.'],
                    ['category' => 'pembelajaran', 'text' => 'Penilaian tugas dan ujian disampaikan secara transparan.'],
                    ['category' => 'pembelajaran', 'text' => 'Materi kuliah relevan dengan capaian pembelajaran mata kuliah.'],
                    ['category' => 'kepuasan_umum', 'text' => 'Secara umum saya puas terhadap proses pembelajaran semester ini.'],
                ],
            ],
            [
                'period' => $currentPeriod,
                'title' => 'Evaluasi Fasilitas Akademik',
                'description' => 'Form evaluasi kepuasan mahasiswa terhadap fasilitas akademik.',
                'target_type' => 'fasilitas',
                'is_active' => true,
                'questions' => [
                    ['category' => 'fasilitas', 'text' => 'Ruang kelas nyaman dan mendukung kegiatan perkuliahan.'],
                    ['category' => 'fasilitas', 'text' => 'Koneksi internet kampus mendukung proses belajar.'],
                    ['category' => 'fasilitas', 'text' => 'Laboratorium atau ruang praktik tersedia sesuai kebutuhan mata kuliah.'],
                    ['category' => 'fasilitas', 'text' => 'Sistem informasi akademik mudah diakses saat dibutuhkan.'],
                    ['category' => 'kepuasan_umum', 'text' => 'Secara umum saya puas terhadap fasilitas akademik yang tersedia.'],
                ],
            ],
            [
                'period' => $previousPeriod,
                'title' => 'Evaluasi Administrasi Semester Ganjil',
                'description' => 'Data historis evaluasi administrasi semester sebelumnya.',
                'target_type' => 'administrasi',
                'is_active' => false,
                'questions' => [
                    ['category' => 'administrasi', 'text' => 'Prosedur surat menyurat akademik mudah dipahami.'],
                    ['category' => 'administrasi', 'text' => 'Waktu penyelesaian layanan administrasi sesuai informasi yang diberikan.'],
                    ['category' => 'layanan_akademik', 'text' => 'Informasi akademik semester sebelumnya terdokumentasi dengan baik.'],
                    ['category' => 'fasilitas', 'text' => 'Fasilitas pelayanan administrasi mudah dijangkau.'],
                    ['category' => 'kepuasan_umum', 'text' => 'Secara umum saya puas terhadap layanan administrasi semester sebelumnya.'],
                ],
            ],
        ])->map(function (array $formData) use ($categories): EvaluationForm {
            $form = EvaluationForm::query()->updateOrCreate(
                ['title' => $formData['title']],
                [
                    'evaluation_period_id' => $formData['period']->id,
                    'description' => $formData['description'],
                    'target_type' => $formData['target_type'],
                    'is_active' => $formData['is_active'],
                ],
            );

            collect($formData['questions'])->each(function (array $questionData, int $index) use ($categories, $form): void {
                Question::query()->updateOrCreate(
                    [
                        'evaluation_form_id' => $form->id,
                        'question_text' => $questionData['text'],
                    ],
                    [
                        'question_category_id' => $categories[$questionData['category']]->id,
                        'sort_order' => $index + 1,
                        'is_required' => true,
                    ],
                );
            });

            return $form;
        });

        $suggestions = [
            'Mohon jadwal konsultasi akademik dibuat lebih rutin.',
            'Layanan akademik sudah baik, informasi sebaiknya tetap dikirim lebih awal.',
            'Koneksi internet di beberapa ruang kelas perlu ditingkatkan.',
            'Sistem informasi akademik membantu, namun waktu akses saat KRS perlu diperhatikan.',
            'Praktikum berjalan baik, ketersediaan laboratorium perlu dijaga.',
            'Petugas akademik sangat membantu saat mahasiswa membutuhkan informasi.',
        ];

        $forms->where('is_active', true)->values()->each(function (EvaluationForm $form, int $formIndex) use ($students, $suggestions): void {
            $questions = $form->questions()->get();

            $students->take(6)->values()->each(function (Student $student, int $studentIndex) use ($form, $formIndex, $questions, $suggestions): void {
                $response = EvaluationResponse::query()->firstOrCreate(
                    [
                        'evaluation_form_id' => $form->id,
                        'student_id' => $student->id,
                    ],
                    [
                        'submitted_at' => now()->subHours(($formIndex * 6) + $studentIndex),
                        'suggestion' => $suggestions[($formIndex + $studentIndex) % count($suggestions)],
                    ],
                );

                $questions->each(function (Question $question, int $questionIndex) use ($response, $formIndex, $studentIndex): void {
                    ResponseAnswer::query()->firstOrCreate(
                        [
                            'response_id' => $response->id,
                            'question_id' => $question->id,
                        ],
                        [
                            'score' => 3 + (($formIndex + $studentIndex + $questionIndex) % 3),
                        ],
                    );
                });
            });
        });

        unset($admin);
    }
}
