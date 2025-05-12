<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Paiement;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;  

class DashboardController extends Controller
{
    public function index()
    {
        $studentCount = Student::count();
        $convocationCount = Student::sum('convocations');
        $absenceCount = Student::sum('absences');
        $paiementCount = Paiement::sum('montant');
        $pensionCount = Paiement::where('typepaiement', 'pension')->count();
        $otherCount = Paiement::where('typepaiement', 'other')->count();

        $monthlyConvocations = Student::selectRaw('MONTH(created_at) as month, SUM(convocations) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

    
        $monthlyConvocations = array_replace(array_fill(1, 12, 0), $monthlyConvocations);

        return view('dashboard', [
            'studentCount' => $studentCount,
            'convocationCount' => $convocationCount,
            'absenceCount' => $absenceCount,
            'paiementCount' => $paiementCount,
            'pensionCount' => $pensionCount,
            'otherCount' => $otherCount,
            'monthlyConvocations' => array_values($monthlyConvocations),
        ]);
    }

    public function generateAbsenceReport()
    {
        $absences = Student::selectRaw('MONTH(created_at) as month, SUM(absences) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $pdf = PDF::loadView('reports.absences', compact('absences'));
        return $pdf->download('rapport_absences.pdf');
    }

    public function generateConvocationReport()
    {
        $convocations = Student::selectRaw('MONTH(created_at) as month, SUM(convocations) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $pdf = PDF::loadView('reports.convocations', compact('convocations'));
        return $pdf->download('rapport_convocations.pdf');
    }

    public function generatePaiementReport()
    {
        $paiements = Paiement::selectRaw('MONTH(created_at) as month, SUM(montant) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $pdf = PDF::loadView('reports.paiements', compact('paiements'));
        return $pdf->download('rapport_paiements.pdf');
    }
}