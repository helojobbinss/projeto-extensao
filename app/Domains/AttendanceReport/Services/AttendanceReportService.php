<?php

namespace App\Domains\AttendanceReport\Services;

use App\Domains\AttendanceReport\Models\AttendanceReport;
use App\Domains\Attendance\Models\Attendance;
use App\Domains\AttendancePresence\Models\AttendancePresence;
use App\Domains\Images\Models\Image;
use Illuminate\Support\Facades\Storage;

class AttendanceReportService
{
    /**
     * Busca ou cria o relatório de uma chamada.
     */
    public function firstOrCreate(Attendance $attendance): AttendanceReport
    {
        $report = AttendanceReport::firstOrCreate([
            'attendance_id' => $attendance->id,
        ]);

        // garante contagem inicial correta
        $this->syncPresenceCounts($report, $attendance);

        return $report;
    }

    /**
     * Salva/atualiza o relatório e processa imagens.
     */
    public function save(
        AttendanceReport $report,
        array $data,
        array $images = []
    ): AttendanceReport {

        $report->fill([
            'title'        => $data['title'] ?? null,
            'description'  => $data['description'] ?? null,
            'activities'   => $data['activities'] ?? null,
            'observations' => $data['observations'] ?? null,
        ]);

        $report->save();

        if (!empty($images)) {
            $this->storeImages($report, $images);
        }

        // atualiza contagem sempre com Attendance real
        $report->load('attendance');
        $this->syncPresenceCounts($report, $report->attendance);

        return $report->fresh(['images']);
    }

    /**
     * Contagem correta de presenças
     */
    private function syncPresenceCounts(
        AttendanceReport $report,
        Attendance $attendance
    ): void {

        $presentCount = AttendancePresence::where('attendance_id', $attendance->id)
            ->where('present', true)
            ->count();

        $absentCount = AttendancePresence::where('attendance_id', $attendance->id)
            ->where('present', false)
            ->count();

        $report->update([
            'present_count' => $presentCount,
            'absent_count'  => $absentCount,
        ]);
    }

    /**
     * Upload de imagens
     */
    private function storeImages(AttendanceReport $report, array $files): void
    {
        foreach ($files as $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            $path = $file->store('reports', 'public');

            $report->images()->create([
                'path'          => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime'          => $file->getMimeType(),
                'size'          => $file->getSize(),
            ]);
        }
    }

    /**
     * Delete imagem
     */
    public function deleteImage(Image $image): void
    {
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();
    }
}