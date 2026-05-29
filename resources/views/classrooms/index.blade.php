@extends('layouts.app')

@section('content')

<div class="container">

    <div class="header">

        <h3>Salas de Aula</h3>

        @if(auth()->user()->isAdmin())

            <a
                href="{{ route('classrooms.create') }}"
                class="btn-new"
            >

                + Nova Sala

            </a>

        @endif

    </div>

    <div class="projects-list">

        @foreach($classrooms as $classroom)

            <div
                class="
                    project-pill
                    {{ $loop->first ? 'active' : '' }}
                "

                onclick="
                    selectClassroom(
                        {{ $classroom->id }},
                        this
                    )
                "
            >

                <div class="pill-title">

                    {{ $classroom->name }}

                </div>

            </div>

        @endforeach

    </div>

    <div
        class="project-details"
        id="classroom-details"
    ></div>

</div>

@endsection

@section('scripts')

<script>

const classrooms = @json(
    $classrooms->items()
);

window.selectClassroom = function (
    id,
    el
) {

    const classroom = classrooms.find(
        c => c.id == id
    );

    if (!classroom) {

        console.error(
            'Sala de aula não encontrada'
        );

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Ativa card selecionado
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.project-pill')
        .forEach(item => {

            item.classList.remove('active');

        });

    el.classList.add('active');

    const container = document.getElementById(
        'classroom-details'
    );

    container.classList.remove('show');

    /*
    |--------------------------------------------------------------------------
    | Weekdays
    |--------------------------------------------------------------------------
    */

    let weekdays = [];

    try {

        weekdays = Array.isArray(
            classroom.weekdays
        )
            ? classroom.weekdays
            : JSON.parse(
                classroom.weekdays || '[]'
            );

    } catch (e) {

        weekdays = [];
    }

    /*
    |--------------------------------------------------------------------------
    | Tradução
    |--------------------------------------------------------------------------
    */

    const translatedWeekdays = weekdays.map(
        day => {

            switch(day) {

                case 'monday':
                    return 'Segunda';

                case 'tuesday':
                    return 'Terça';

                case 'wednesday':
                    return 'Quarta';

                case 'thursday':
                    return 'Quinta';

                case 'friday':
                    return 'Sexta';

                case 'saturday':
                    return 'Sábado';

                case 'sunday':
                    return 'Domingo';

                default:
                    return day;
            }
        }
    );

    /*
    |--------------------------------------------------------------------------
    | Renderiza card
    |--------------------------------------------------------------------------
    */

    setTimeout(() => {

        container.innerHTML = `

            <div class="header">

                <div class="header-left">

                    <div class="icon">
                        🏫
                    </div>

                    <div>

                        <h5>
                            ${classroom.name}
                        </h5>

                        <small>
                            ${
                                classroom.description ?? ''
                            }
                        </small>

                    </div>

                </div>

                ${renderAdminActions(classroom)}

            </div>

            <div class="project-grid">

                <div>

                    <span>
                        📅 Dias
                    </span>

                    <strong>
                        ${
                            translatedWeekdays.join(', ')
                            || '-'
                        }
                    </strong>

                </div>

                <div>

                    <span>
                        📆 Período
                    </span>

                    <strong>

                        ${
                            classroom.starts_on ?? '-'
                        }

                        até

                        ${
                            classroom.ends_on ?? '-'
                        }

                    </strong>

                </div>

                <div>

                    <span>
                        ⏱️ Horário
                    </span>

                    <strong>

                        ${
                            classroom.start_time ?? '-'
                        }

                        às

                        ${
                            classroom.end_time ?? '-'
                        }

                    </strong>

                </div>

            </div>

        `;

        container.classList.add('show');

    }, 120);
};

/*
|--------------------------------------------------------------------------
| Ações admin
|--------------------------------------------------------------------------
*/

function renderAdminActions(classroom)
{
    @if(auth()->user()->isAdmin())

        return `

            <div class="actions">

                <a
                    href="/classrooms/${classroom.id}/edit"
                    class="btn-edit"
                >

                    <i class="fa-solid fa-pen"></i>

                </a>

                <form
                    method="POST"
                    action="/classrooms/${classroom.id}"

                    onsubmit="
                        return confirm(
                            'Deseja excluir esta sala de aula?'
                        )
                    "
                >

                    <input
                        type="hidden"
                        name="_token"
                        value="{{ csrf_token() }}"
                    >

                    <input
                        type="hidden"
                        name="_method"
                        value="DELETE"
                    >

                    <button
                        type="submit"
                        class="btn-danger"
                    >

                        <i class="fa-solid fa-trash"></i>

                    </button>

                </form>

            </div>

        `;

    @else

        return '';

    @endif
}

/*
|--------------------------------------------------------------------------
| Seleciona primeiro item automaticamente
|--------------------------------------------------------------------------
*/

window.addEventListener(
    'DOMContentLoaded',
    () => {

        if (classrooms.length) {

            const first = document.querySelector(
                '.project-pill'
            );

            selectClassroom(
                classrooms[0].id,
                first
            );
        }
    }
);

</script>

@endsection