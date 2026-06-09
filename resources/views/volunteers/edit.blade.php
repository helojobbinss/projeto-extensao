@extends('layouts.app')

@section('content')

<div class="card-box">

    <form
        action="{{ route('volunteers.update', $volunteer->id) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">

                <label class="form-label">
                    Nome
                </label>

                <input
                    type="text"
                    class="input"
                    value="{{ $volunteer->user?->name ?? '-' }}"
                    disabled
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    E-mail
                </label>

                <input
                    type="text"
                    class="input"
                    value="{{ $volunteer->user?->email ?? '-' }}"
                    disabled
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Projeto
                </label>

                <input
                    type="text"
                    class="input"
                    value="{{ $volunteer->project?->name ?? '-' }}"
                    disabled
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Telefone
                </label>

                <input
                    type="text"
                    class="input"
                    value="{{ $volunteer->user?->phone ?? '-' }}"
                    disabled
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Data de Nascimento
                </label>

                <input
                    type="text"
                    class="input"
                    value="{{ optional($volunteer->user?->birthday)->format('d/m/Y') ?? '-' }}"
                    disabled
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Idade
                </label>

                <input
                    type="text"
                    class="input"
                    value="{{ $volunteer->user?->age ?? '-' }}"
                    disabled
                >

            </div>

            <div class="form-group full-width">

                <label class="form-label">
                    Status
                </label>

                <select
                    name="status"
                    class="select"
                >

                    <option
                        value="pending"
                        {{ $volunteer->status == 'pending' ? 'selected' : '' }}
                    >
                        Pendente
                    </option>

                    <option
                        value="approved"
                        {{ $volunteer->status == 'approved' ? 'selected' : '' }}
                    >
                        Aprovado
                    </option>

                    <option
                        value="rejected"
                        {{ $volunteer->status == 'rejected' ? 'selected' : '' }}
                    >
                        Rejeitado
                    </option>

                </select>

            </div>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Salvar Alterações
            </button>

            <a
                href="{{ route('volunteers') }}"
                class="btn btn-outline"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection