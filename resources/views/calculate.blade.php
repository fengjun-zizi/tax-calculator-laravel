<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tax Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container bg-white rounded shadow p-5" style="max-width: 700px;">
        <h1 class="mb-4 text-center text-primary">Tax Calculator</h1>

        {{-- 错误提示 --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There was a problem with your input:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 成功消息 --}}
        @if (session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif

        {{-- 表单 --}}
        <form method="POST" action="/calculate">
            @csrf
            <div class="mb-3">
                <label for="income" class="form-label">Enter your income (IDR):</label>
                <input type="text" name="income" id="income" class="form-control" value="{{ old('income') }}" placeholder="e.g. 5800000">
            </div>
            <button type="submit" class="btn btn-primary w-100">Calculate Tax</button>
        </form>

        {{-- 结果展示 --}}
        @isset($taxRate)
            <div class="alert alert-success mt-4">
                <h5>Calculation Result:</h5>
                <p><strong>Tax Rate:</strong> {{ $taxRate }}%</p>
                <p><strong>Tax Amount:</strong> IDR {{ number_format($tax) }}</p>
            </div>
        @endisset

        {{-- 历史记录表 --}}
        @if (isset($history) && $history->count())
            <h4 class="mt-5">Recent Calculations</h4>
            <table class="table table-bordered mt-2">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Income</th>
                        <th>Tax Rate (%)</th>
                        <th>Tax (IDR)</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($history as $record)
    <tr id="row-{{ $record->id }}">
        <td>{{ $record->id }}</td>
        <td>IDR {{ number_format($record->income) }}</td>
        <td>{{ $record->tax_rate }}</td>
        <td>IDR {{ number_format($record->tax_amount) }}</td>
        <td>{{ $record->created_at->format('Y-m-d H:i') }}</td>
        <td>
            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $record->id }}">
                Delete
            </button>
        </td>
    </tr>
@endforeach
                </tbody>
            </table>

            {{-- 分页 --}}
            <div class="mt-3">
                {{ $history->links() }}
            </div>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        $('.delete-btn').click(function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        if (!confirm('Are you sure to delete this record?')) return;

        $.ajax({
                url: '/calculate/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {
                    $('#row-' + id).fadeOut(300, function () {
                        $(this).remove();
                    });
                },
                error: function () {
                    alert('Failed to delete the record.');
                }
            });
        });
    });
</script>
</body>
</html>