<section id="projects">
    <h1>Nossos projetos</h1>
    <div id="projectsCarousel" class="carousel slide" data-bs-ride="carousel">

<div class="projects-section">

    <h2 class="section-title">Projetos Ativos</h2>

    <div class="carousel">
        <button class="carousel-btn prev" id="prevBtn">‹</button>

        <div class="carousel-viewport">
            <div class="carousel-track" id="carouselTrack">

                @foreach ($projects as $project)

                    <div class="card">
                        <div class="card-content">

                            <h3 class="project-title">
                                {{ $project->name }}
                            </h3>

                            <p class="project-description">
                                {{ Str::limit($project->description, 120) }}
                            </p>

                            <div class="project-meta">

                                <div class="coordinator">
                                    <strong>Coordenador:</strong><br>
                                    {{ $project->coordinator->name ?? 'Não definido' }}
                                </div>

                            </div>

                        </div>
                    </div>

                @endforeach

            </div>
        </div>

        <button class="carousel-btn next" id="nextBtn">›</button>
    </div>

</div>

</div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {

    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    const cards = document.querySelectorAll('#carouselTrack .card');

    const cardsPerView = 3;

    let currentIndex = 0;

    const totalSlides = Math.ceil(cards.length / cardsPerView);

    function updateCarousel() {
        const cardWidth = cards[0].offsetWidth;

        const offset = currentIndex * (cardWidth * cardsPerView);

        track.style.transform = `translateX(-${offset}px)`;
    }

    nextBtn.addEventListener('click', () => {
        currentIndex++;

        if (currentIndex >= totalSlides) {
            currentIndex = 0; // loop infinito
        }

        updateCarousel();
    });

    prevBtn.addEventListener('click', () => {
        currentIndex--;

        if (currentIndex < 0) {
            currentIndex = totalSlides - 1; // volta pro fim
        }

        updateCarousel();
    });

    window.addEventListener('resize', updateCarousel);

    updateCarousel();
});
</script>