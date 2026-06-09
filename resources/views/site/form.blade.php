<div class="volunteer-container" id="volunteers">

    <div class="volunteer-card">

        <h2>Seja um Voluntário</h2>

        <p>
            Preencha o formulário abaixo para participar dos nossos projetos.
            Após análise da equipe, entraremos em contato.
        </p>

        @if(session('success'))

            <div class="alert-success">
                {{ session('success') }}
            </div>

        @endif

        @if ($errors->any())

            <div class="alert-danger">

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('volunteer.apply') }}"
            method="POST"
            class="volunteer-form"
        >

            @csrf

            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Nome completo *
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Digite seu nome completo"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        E-mail *
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Digite seu e-mail"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        Data de nascimento *
                    </label>

                    <input
                        type="date"
                        name="birthdate"
                        value="{{ old('birthdate') }}"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>
                        Telefone
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="(00) 00000-0000"
                    >

                </div>

                <div class="form-group full-width">

                    <label>
                        Projeto de interesse *
                    </label>

                    <select
                        name="project_id"
                        required
                    >

                        <option value="">
                            Selecione um projeto
                        </option>

                        @foreach ($projects as $project)

                            <option
                                value="{{ $project->id }}"
                                {{
                                    old('project_id') == $project->id
                                        ? 'selected'
                                        : ''
                                }}
                            >
                                {{ $project->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="form-group full-width">

                    <label>
                        Como você gostaria de ajudar?
                    </label>

                    <textarea
                        name="motivation"
                        rows="5"
                        class="form-control"
                        placeholder="Conte um pouco sobre sua disponibilidade, habilidades e motivação para participar."
                    >{{ old('motivation') }}</textarea>

                </div>

                <div class="form-group full-width">

                    <label class="checkbox-label">

                        <input
                            type="checkbox"
                            name="terms"
                            value="1"
                            required
                        >

                        Concordo com o tratamento dos meus dados para fins de cadastro e avaliação como voluntário.

                    </label>

                </div>

            </div>

            <button
                type="submit"
                class="btn-submit"
            >
                Quero ser Voluntário
            </button>

        </form>

    </div>

</div>