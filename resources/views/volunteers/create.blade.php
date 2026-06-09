@extends('layouts.app')

@section('content')

<div class="page-header">

    <div>
        <h2>Voluntários</h2>

        <div class="subtitle">
            Preencha as informações necessárias para cadastrar voluntários.
        </div>
    </div>

</div>

<div class="card-box">

    <form method="POST" action="{{ route('volunteers.store') }}">

        @csrf

        <div class="form-grid">

            {{-- COLUNA ESQUERDA --}}
            <div>

                {{-- NOME --}}
                <div class="form-group">

                    <label>
                        Nome <span class="required">*</span>
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Nome do Voluntário"
                           value="{{ old('name') }}"
                           required>

                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                {{-- DATA NASCIMENTO + IDADE --}}
                <div class="form-row">

                    <div class="form-group">

                        <label>
                            Data de Nascimento
                            <span class="required">*</span>
                        </label>

                        <input type="date"
                               name="birthday"
                               class="form-control @error('birthday') is-invalid @enderror"
                               value="{{ old('birthday') }}"
                               required>

                        @error('birthday')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                    <div class="form-group">

                        <label>Idade</label>

                        <input type="number"
                               name="age"
                               class="form-control @error('age') is-invalid @enderror"
                               placeholder="Idade"
                               value="{{ old('age') }}">

                        @error('age')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>

                </div>

                {{-- TELEFONE --}}
                <div class="form-group">

                    <label>
                        Telefone <span class="required">*</span>
                    </label>

                    <input type="text"
                           name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           placeholder="(99) 9 9999-9999"
                           value="{{ old('phone') }}"
                           required>

                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                {{-- EMAIL --}}
                <div class="form-group">

                    <label>
                        E-mail <span class="required">*</span>
                    </label>

                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="e-mail.cadastro@gmail.com"
                           value="{{ old('email') }}"
                           required>

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

            </div>

            <div class="divider"></div>

            {{-- COLUNA DIREITA --}}
            <div>

                {{-- PROJETO --}}
                <div class="form-group">

                    <label>Projetos</label>

                    <select name="project_id"
                            class="form-control @error('project_id') is-invalid @enderror">

                        <option value="">
                            Selecione
                        </option>

                        @foreach($projects as $project)

                            <option value="{{ $project->id }}"
                                {{ old('project_id') == $project->id ? 'selected' : '' }}>

                                {{ $project->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('project_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                {{-- STATUS --}}
                <div class="form-group">

                    <label>Status</label>

                    <select name="status"
                            class="form-control @error('status') is-invalid @enderror">

                        <option value="approved"
                            {{ old('status') == 'approved' ? 'selected' : '' }}>
                            Ativo
                        </option>

                        <option value="pending"
                            {{ old('status') == 'pending' ? 'selected' : '' }}>
                            Pendente
                        </option>

                        <option value="rejected"
                            {{ old('status') == 'rejected' ? 'selected' : '' }}>
                            Rejeitado
                        </option>

                    </select>

                    @error('status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

            </div>

        </div>

        {{-- BOTÕES --}}
        <div class="form-actions">

            <a href="{{ route('volunteers') }}"
               class="btn btn-ghost">

                CANCELAR

            </a>

            <button type="submit"
                    class="btn btn-primary">

                SALVAR

            </button>

        </div>

    </form>

</div>

@endsection