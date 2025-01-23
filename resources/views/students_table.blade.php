<!-- resources/views/students/partials/students_table.blade.php -->

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Classe</th>
            <th>Date d'inscription</th>
            <th>Absences</th>
            <th>Convocations</th>
            <th>Avertissements</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->class }}</td>
            <td>{{ $student->enrollment_date }}</td>
            <td>{{ $student->absences }}</td>
            <td>{{ $student->convocations }}</td>
            <td>{{ $student->warnings }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
