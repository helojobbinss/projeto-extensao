@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="header">
            <h3>Conheça nossos Projetos</h3>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('projects.create') }}" class="btn-new">
                    + Novo Projeto
                </a>
            @endif
        </div>


        <div class="projects-list">
            @foreach($projects as $project)
                <div class="project-pill {{ $loop->first ? 'active' : '' }}" onclick="selectProject({{ $project->id }}, this)">

                    <div class="pill-title">
                        {{ $project->name }}
                    </div>

                    <div class="pill-description">
                        {{ $project->description }}
                    </div>

                </div>
            @endforeach
        </div>

        <!-- 🔹 CARD GRANDE (DETALHES) -->
        <div class="project-details" id="project-details"></div>

    </div>

@endsection

@section('scripts')
<script>

const projects = @json($projects->values());

window.selectProject = function (id, el) {
    const project = projects.find(p => p.id == id);

    if (!project) {
        console.error('Projeto não encontrado');
        return;
    }

    document.querySelectorAll('.project-pill').forEach(item => {
        item.classList.remove('active');
    });

    el.classList.add('active');

    const container = document.getElementById('project-details');


    container.classList.remove('show');

    setTimeout(() => {

        container.innerHTML = `
            <div class="header">

                <div class="header-left">
                    <div class="icon">📘</div>
                    <div>
                        <h5>${project.name}</h5>
                        <small>${project.description ?? ''}</small>
                    </div>
                </div>

                ${renderAdminActions(project)}

            </div>

            <div class="project-grid">

                <div>
                    <span>👤 Coordenador</span>
                    <strong>${project.coordinator?.name ?? '-'}</strong>
                </div>

                <div>
                    <span>👥 Público</span>
                    <strong>${project.target_audience ?? '-'}</strong>
                </div>

                <div>
                    <span>📍 Local</span>
                    <strong>${project.location ?? '-'}</strong>
                </div>

                <div>
                    <span>🎯 Vagas</span>
                    <strong>${project.vacancies ?? 0}</strong>
                </div>

                <div>
                    <span>📅 Período</span>
                    <strong>
                        ${formatDate(project.start_date)} até ${formatDate(project.end_date)}
                    </strong>
                </div>

                <div>
                    <span>Status</span>
                    ${renderStatus(project.status)}
                </div>

            </div>
        `;

        // 🔥 animação: mostra depois
        container.classList.add('show');

    }, 120);
};


// ===== HELPERS =====

function formatDate(date) {
    if (!date) return '-';
    const d = new Date(date);
    return d.toLocaleDateString('pt-BR');
}

function renderStatus(status) {
    if (status === 'active') {
        return '<span class="badge bg-success">Ativo</span>';
    }
    if (status === 'inactive') {
        return '<span class="badge bg-secondary">Inativo</span>';
    }
    return '<span class="badge bg-dark">Finalizado</span>';
}

function renderAdminActions(project) {
    @if(auth()->user()->isAdmin())
        return `
            <div class="actions">

                <a href="/projects/${project.id}/edit"
                   class="btn-edit">
                    <i class="fa-solid fa-pen"></i>
                </a>

                <form method="POST" action="/projects/${project.id}" onsubmit="return confirm('Deseja excluir este projeto?')">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">

                    <button type="submit" class="btn-danger">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>

            </div>
        `;
    @else
        return '';
    @endif
}


// ===== INIT =====

window.addEventListener('DOMContentLoaded', () => {
    if (projects.length) {
        const first = document.querySelector('.project-pill');
        selectProject(projects[0].id, first);
    }
});

</script>
@endsection