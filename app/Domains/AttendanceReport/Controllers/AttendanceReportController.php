<?php

namespace App\Domains\AttendanceReport\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Attendance\Models\Attendance;
use App\Domains\AttendanceReport\Models\AttendanceReport;
use App\Domains\AttendanceReport\Requests\AttendanceReportRequest;
use App\Domains\AttendanceReport\Services\AttendanceReportService;
use App\Domains\Images\Models\Image;

class AttendanceReportController extends Controller
{
    public function __construct(
        private AttendanceReportService $service
    ) {}

    /**
     * Exibe o formulário do relatório de uma chamada.
     * NÃO cria registro aqui (somente leitura).
     */
    public function edit(Attendance $attendance)
    {
        $attendance->load([
            'project.participants.user',
            'presences.participant',
        ]);

        // 🔥 NÃO quebra se não existir relatório
        $report = AttendanceReport::where('attendance_id', $attendance->id)->first();

        // 🔥 contagem direta (fonte real de dados)
        $presentCount = $attendance->presences
            ->where('present', true)
            ->count();

        $absentCount = $attendance->presences
            ->where('present', false)
            ->count();

        // 🔥 evita erro caso report seja null
        if ($report) {
            $report->present_count = $presentCount;
            $report->absent_count = $absentCount;

            $report->load('images');
        } else {
            // cria objeto vazio só para a view não quebrar
            $report = new AttendanceReport();
            $report->present_count = $presentCount;
            $report->absent_count = $absentCount;
            $report->images = collect();
        }

        return view('attendances.report', compact(
            'attendance',
            'report'
        ));
    }

    /**
     * Salva/atualiza o relatório com texto e imagens.
     */
    public function update(
        AttendanceReportRequest $request,
        Attendance $attendance
    )
    {
        $report = AttendanceReport::firstOrNew([
            'attendance_id' => $attendance->id
        ]);

        $this->service->save(
            $report,
            $request->validated(),
            $request->file('images', [])
        );

        return redirect()
            ->route('attendances.report.edit', $attendance->id)
            ->with('success', 'Relatório salvo com sucesso!');
    }

    /**
     * Remove uma imagem específica do relatório.
     */
    public function destroyImage(Attendance $attendance, Image $image)
    {
        $report = AttendanceReport::where('attendance_id', $attendance->id)
            ->firstOrFail();

        abort_unless(
            $image->imageable_type === AttendanceReport::class
            && $image->imageable_id === $report->id,
            403,
            'Esta imagem não pertence a este relatório.'
        );

        $this->service->deleteImage(l.log);

        return redirect()
            ->route('attendances.report.edit', $attendance->id)
            ->with('success', 'Imagem removida com sucesso!');
    }
}