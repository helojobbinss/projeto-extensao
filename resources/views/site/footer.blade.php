<section id="footer">
    <div class="footer-container">

        {{-- CONTATO --}}
        <div class="footer-section">
            <h3>Contato</h3>

            <p>Email: {{ setting('contact.email') ?? '—' }}</p>
            <p>Telefone: {{ setting('site.phone') ?? '—' }}</p>
            <p>Endereço: {{ setting('site.address') ?? '—' }}</p>
        </div>

        {{-- LINKS RÁPIDOS --}}
        <div class="footer-section">
            <h3>Links rápidos</h3>

            <ul>
                <li><a href="{{ url('/') }}">Início</a></li>
                <li><a href="#about">Sobre</a></li>
                <li><a href="#volunteers">Contato</a></li>
                <li><a href={{ route('calendar')}}>Calendário</a></li>
            </ul>
        </div>

        {{-- LOGIN / PAINEL --}}
        <div class="footer-section">
            <h3>Acesso</h3>

            @auth
                <p>Bem-vindo, {{ auth()->user()->name }}</p>

                <a href="{{ url('/projects') }}" class="btn btn-primary">
                    Ir para o painel
                </a>

            @else
                <p>Acesse sua conta para gerenciar o sistema.</p>

                <a href="{{ route('login') }}" class="btn btn-primary">
                    Login
                </a>
            @endauth
        </div>

    </div>

    {{-- RODAPÉ INFERIOR --}}
    <div class="footer-bottom">
        <p>
            © 
            Todos os direitos reservados.
        </p>
    </div>
</section>