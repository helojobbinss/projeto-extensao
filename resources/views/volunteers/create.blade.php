@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h2>Voluntários</h2>
        <div class="subtitle">Preencha as informações necessárias para cadastrar voluntários.</div>
    </div>
</div>

<div class="card-box">
<form method="POST" action="{{ route('volunteers.store') }}">
    @csrf

    <div class="form-grid">
        {{-- COLUNA ESQUERDA --}}
        <div>
            <div class="form-group">
                <label>Nome <span class="required">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Nome do Voluntário" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Data de Nascimento <span class="required">*</span></label>
                    <input type="date" name="birthday" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Idade</label>
                    <input type="number" name="age" class="form-control" placeholder="Idade">
                </div>
            </div>

            <div class="form-group">
                <label>Telefone <span class="required">*</span></label>
                <input type="text" name="phone" class="form-control" placeholder="(99) 9 9999-9999" required>
            </div>

            <div class="form-group">
                <label>E-mail <span class="required">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="e-mail.cadastro@gmail.com" required>
            </div>
        </div>

        <div class="divider"></div>

        {{-- COLUNA DIREITA --}}
        <div>
            <div class="form-group">
                <label>Projetos</label>
                <select name="project_id" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="approved">Ativo</option>
                    <option value="pending">Pendente</option>
                    <option value="rejected">Rejeitado</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('volunteers') }}" class="btn btn-ghost">CANCELAR</a>
        <button type="submit" class="btn btn-primary">SALVAR</button>
    </div>
</form>
</div>
@endsection
