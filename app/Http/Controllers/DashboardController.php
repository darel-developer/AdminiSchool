<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Paiement;
use App\Models\Teacher;
use Illuminate\Http\Request;

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

        // Fill missing months with 0 convocations
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
}