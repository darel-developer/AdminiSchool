<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Paiement;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;  

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

        $pdf = Pdf::loadView('reports.absences', compact('absences'));
        return $pdf->download('rapport_absences.pdf');
    }

    public function generateConvocationReport()
    {
        $convocations = Student::selectRaw('MONTH(created_at) as month, SUM(convocations) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $pdf = Pdf::loadView('reports.convocations', compact('convocations'));
        return $pdf->download('rapport_convocations.pdf');
    }

    public function generatePaiementReport()
    {
        $paiements = Paiement::selectRaw('MONTH(created_at) as month, SUM(montant) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $pdf = Pdf::loadView('reports.paiements', compact('paiements'));
        return $pdf->download('rapport_paiements.pdf');
    }

    public function customChartData(Request $request)
    {
        $types = $request->input('types', []);
        $criteria = $request->input('criteria', 'count');
        $result = [];

        foreach ($types as $type) {
            switch ($type) {
                case 'students':
                    $query = \App\Models\Student::query();
                    $label = 'Elèves';
                    $data = [];
                    if ($criteria === 'sum') {
                        $data[] = $query->count();
                    } elseif ($criteria === 'count') {
                        $data[] = $query->count();
                    } elseif ($criteria === 'top5') {
                        $data = $query->orderByDesc('created_at')->limit(5)->pluck('id')->toArray();
                    } else {
                        $data = $query->count();
                    }
                    $result[] = [
                        'label' => $label,
                        'data' => $data,
                    ];
                    break;
                case 'paiements':
                    $query = \App\Models\Paiement::query();
                    $label = 'Paiements';
                    $data = [];
                    if ($criteria === 'sum') {
                        $data[] = $query->sum('montant');
                    } elseif ($criteria === 'count') {
                        $data[] = $query->count();
                    } elseif ($criteria === 'top5') {
                        $data = $query->orderByDesc('montant')->limit(5)->pluck('montant')->toArray();
                    } else {
                        $data = $query->count();
                    }
                    $result[] = [
                        'label' => $label,
                        'data' => $data,
                    ];
                    break;
                case 'absences':
                    $query = \App\Models\Student::query();
                    $label = 'Absences';
                    $data = [];
                    if ($criteria === 'sum') {
                        $data[] = $query->sum('absences');
                    } elseif ($criteria === 'count') {
                        $data[] = $query->where('absences', '>', 0)->count();
                    } elseif ($criteria === 'top5') {
                        $data = $query->orderByDesc('absences')->limit(5)->pluck('absences')->toArray();
                    } else {
                        $data = $query->sum('absences');
                    }
                    $result[] = [
                        'label' => $label,
                        'data' => $data,
                    ];
                    break;
                // Ajouter d'autres types si besoin
            }
        }

        // Générer les labels selon le critère
        if ($criteria === 'top5') {
            $labels = ['1', '2', '3', '4', '5'];
        } else {
            $labels = array_map(function($item) {
                return $item['label'];
            }, $result);
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => array_map(function($item) {
                return [
                    'label' => $item['label'],
                    'data' => $item['data'],
                ];
            }, $result),
        ]);
    }
}