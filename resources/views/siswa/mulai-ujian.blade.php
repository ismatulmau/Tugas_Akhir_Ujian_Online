@extends('layouts.app-siswa')
@section('title', 'Ujian')

<style>
    .card-header .badge-danger {
        color: #ffffff !important;
        background-color: #dc3545;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .form-check {
        margin-bottom: 0.8rem;
        padding: 0.5rem;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .form-check:hover {
        background-color: #f8f9fa;
    }

    .form-check-input {
        margin-right: 0.5rem;
        transform: scale(1.2);
    }

    .form-check-label {
        margin-bottom: 0;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn {
        padding: 0.5rem 1.2rem;
        font-size: 0.95rem;
        font-weight: 500;
        border-radius: 0.3rem;
        transition: all 0.3s ease;
        min-width: 100px;
    }

    .btn-primary {
        color: #ffffff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
        background-color: transparent;
    }

    .btn-primary:hover {
        color: #ffffff;
        background-color: #0056b3;
        border-color: #004085;
        transform: translateY(-1px);
    }

    .btn-outline-primary:hover {
        color: #ffffff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-warning {
        color: #fd7e14;
        border-color: #fd7e14;
        background-color: transparent;
    }

    .btn-outline-warning:hover {
        color: #ffffff;
        background-color: #fd7e14;
        border-color: #fd7e14;
    }

    .btn-warning {
        color: #ffffff;
        background-color: #fd7e14;
        border-color: #fd7e14;
    }

    .btn-warning:hover {
        color: #ffffff;
        background-color: #e55300;
        border-color: #e55300;
        transform: translateY(-1px);
    }

    .btn-success {
        color: #ffffff;
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
        transform: translateY(-1px);
    }

    .card-header {
        font-size: 1.2rem;
        padding: 1rem 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .question-nav {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0.3rem;
        font-weight: 500;
    }

    .question-nav.active {
        color: white !important;
    }

    .img-thumbnail {
        max-width: 100%;
        height: auto;
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
    }

    @media (max-width: 768px) {

        .col-md-8,
        .col-md-4 {
            width: 100%;
        }

        .d-flex.justify-content-end {
            justify-content: center !important;
        }

        .btn {
            margin-bottom: 0.5rem;
            width: 100%;
        }
    }
</style>

@section('content')
<div class="container mt-2">
    <!-- <div class="row mb-2">
        <div class="col-md-12">
            <div class="card bg-light p-1 mb-1">
                <div class="card-body">
                    <p class="mb-1"><strong>Ujian:</strong> {{ $ujian->bankSoal->nama_bank_soal }}</p>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('ujian.submit', $ujian->id_sett_ujian) }}" method="POST" id="exam-form">
                @csrf
                <div id="question-container">
                    @foreach($soals as $index => $soal)
                    <div class="card mb-4 question" id="question-{{ $index }}" style="{{ $index === 0 ? '' : 'display:none;' }}">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <span>Soal {{ $index + 1 }}</span>
                            <span>
                                <strong>Waktu tersisa: </strong>
                                <span id="time-remaining-{{ $index }}" class="badge badge-danger"></span>
                            </span>
                        </div>

                        <div class="card-body">
                            <div class="question-text mb-3">
                                {!! $soal->pertanyaan !!}
                            </div>

                            @if($soal->gambar_soal)
                            <div class="question-image mb-3">
                                <img src="{{ asset('storage/soal_images/' . $soal->gambar_soal) }}" alt="Gambar Soal" class="img-fluid">
                            </div>
                            @endif

                            <div class="options-container">
                                @foreach(['A', 'B', 'C', 'D', 'E'] as $opsi)
                                @php $opsi_text = 'opsi_' . strtolower($opsi); @endphp
                                @if($soal->$opsi_text)
                                <div class="form-check option-item">
                                    <input class="form-check-input"
                                        type="radio"
                                        name="jawaban[{{ $soal->id_soal }}]"
                                        value="{{ $opsi }}"
                                        id="soal{{ $soal->id_soal }}_{{ $opsi }}">
                                    <label class="form-check-label" for="soal{{ $soal->id_soal }}_{{ $opsi }}">
                                        {{ $opsi }}. {{ $soal->$opsi_text }}
                                    </label>
                                </div>
                                @endif
                                @endforeach
                            </div>

                            <div class="question-actions d-flex justify-content-between mt-4">
                                @if($index > 0)
                                <button type="button" class="btn btn-outline-primary prev-question">Sebelumnya</button>
                                @else
                                <div></div>
                                @endif

                                <button type="button" class="btn btn-warning ragu-question">Ragu-ragu</button>

                                @if($index < count($soals) - 1)
                                    <button type="button" class="btn btn-primary next-question">Selanjutnya</button>
                                    @else
                                    <button type="submit" class="btn btn-success" id="submit-button">Simpan Jawaban</button>
                                    @endif
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>


            </form>
        </div>

        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Daftar Soal</h5>
                </div>
                <div class="card-body">
                    <div class="questions-navigation d-flex flex-wrap">
                        @foreach($soals as $index => $soal)
                        <button type="button"
                            class="btn btn-outline-primary question-nav m-1"
                            data-index="{{ $index }}">
                            {{ $index + 1 }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elemen DOM
        const questions = document.querySelectorAll('.question');
        const nextButtons = document.querySelectorAll('.next-question');
        const skipButtons = document.querySelectorAll('.prev-question');
        const raguButtons = document.querySelectorAll('.ragu-question');
        const navButtons = document.querySelectorAll('.question-nav');
        const form = document.getElementById('exam-form');
        const timerElements = document.querySelectorAll('[id^="time-remaining-"]');

        // Durasi ujian
        const examDurationMinutes = {{ $ujian->durasi }};

        const examDurationMillis = examDurationMinutes * 60 * 1000;

        // Timer management
        let examStartTime = localStorage.getItem('examStartTime');
        if (!examStartTime) {
            examStartTime = new Date().getTime();
            localStorage.setItem('examStartTime', examStartTime);
        }

        const examEndTime = parseInt(examStartTime) + examDurationMillis;
        let timerInterval;

        // Fungsi update timer
        function updateTimer() {
            const now = new Date().getTime();
            const distance = examEndTime - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                Swal.fire({
                    title: 'Waktu Habis!',
                    text: "Waktu ujian Anda telah habis. Jawaban Anda akan disimpan secara otomatis.",
                    icon: 'info',
                    confirmButtonText: 'Oke'
                }).then(() => {
                    localStorage.removeItem('examStartTime');
                    form.submit();
                });
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            timerElements.forEach(timerElement => {
                timerElement.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            });
        }

        // Inisialisasi timer
        updateTimer();
        timerInterval = setInterval(updateTimer, 1000);

        // Navigasi soal
        function showQuestion(index) {
            questions.forEach((question, i) => {
                question.style.display = i === index ? 'block' : 'none';
            });

            // Update tombol submit
            // finalSubmitButton.style.display = index === questions.length - 1 ? 'block' : 'none';

            // Update status navigasi
            navButtons.forEach((btn, i) => {
                btn.classList.toggle('active', i === index);
            });
        }

        // Event listeners untuk tombol navigasi
        navButtons.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        showQuestion(index);
    });
});


        // Tombol selanjutnya
        nextButtons.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        showQuestion(index + 1);
    });
});

document.querySelectorAll('.prev-question').forEach((btn, index) => {
    btn.addEventListener('click', () => {
        showQuestion(index);
    });
});


        // Tombol ragu-ragu
        raguButtons.forEach(button => {
            button.addEventListener('click', function() {
                const currentQuestion = this.closest('.question');
                const currentIndex = parseInt(currentQuestion.id.split('-')[1]);

                // Toggle status ragu-ragu
                const navButton = navButtons[currentIndex];
                navButton.classList.toggle('btn-warning');
                navButton.classList.toggle('btn-outline-primary');

                // Beri feedback
                this.classList.add('btn-outline-warning');
                this.textContent = 'Ragu!';
                setTimeout(() => {
                    this.classList.remove('btn-outline-warning');
                    this.textContent = 'Ragu-ragu';
                }, 1000);
            });
        });

        // Update status jawaban di navigasi
        form.addEventListener('change', function(e) {
            if (e.target.matches('.form-check-input')) {
                const questionId = e.target.closest('.question').id;
                const questionIndex = parseInt(questionId.split('-')[1]);
                const navButton = navButtons[questionIndex];

                // Cek apakah ada jawaban yang dipilih
                const inputs = document.querySelectorAll(`#${questionId} .form-check-input`);
                let answered = false;
                inputs.forEach(input => {
                    if (input.checked) answered = true;
                });

                // Update tampilan navigasi
                if (answered) {
                    navButton.classList.add('btn-primary');
                    navButton.classList.remove('btn-outline-primary', 'btn-warning');
                }
            }
        });

        // Konfirmasi submit
        form.addEventListener('submit', function(e) {
            e.preventDefault();



            Swal.fire({
                title: 'Konfirmasi',
                html: `Apakah Anda yakin ingin menyimpan jawaban?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem('examStartTime');
                    form.submit();
                }
            });
        });

        // Inisialisasi status navigasi awal
        showQuestion(0);
    });
</script>
@endsection