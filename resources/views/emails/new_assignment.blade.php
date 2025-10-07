<!DOCTYPE html>
<html>

<head>
    <title>Tugas Baru</title>
</head>

<body>
    <p>Email dikirim pada: {{ now()->format('Y-m-d H:i:s') }}</p>
    <p>Kepada: {{ $recipient ?? 'Mahasiswa' }}</p>
    <h1>Halo!</h1>
    <p>Ada tugas baru di mata kuliah <strong>{{ $assignment->course->name }}</strong>.</p>

    <h2>{{ $assignment->title }}</h2>
    <p>{{ $assignment->description }}</p>
    <p><strong>Deadline:</strong> {{ $assignment->deadline->format('d F Y, H:i') }}</p>

    <p>Silakan login ke sistem e-learning untuk melihat detailnya.</p>
    <p>Terima kasih!</p>
</body>

</html>
