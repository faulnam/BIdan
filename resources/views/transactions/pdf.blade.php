<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Transaction #{{ $transaction->id }}</title>
  <style>
    body { font-family: sans-serif; }
    .header { font-size: 24px; font-weight: bold; margin-bottom: 20px; }
    .section { margin-bottom: 15px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #999; padding: 8px; text-align: left; }
  </style>
</head>
<body>
  <div class="header">Transaction Report</div>

  <div class="section">
    <strong>Transaction ID:</strong> {{ $transaction->id }}<br>
    <strong>Date:</strong> {{ $transaction->date->format('d/m/Y H:i') }}<br>
    <strong>Patient:</strong> {{ $transaction->patient->name }}<br>
    <strong>Staff:</strong> {{ $transaction->staff->name ?? '-' }}<br>
    <strong>Status:</strong> {{ ucfirst($transaction->status) }}<br>
  </div>

  <div class="section">
    <strong>Items:</strong>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Qty</th>
          <th>Price</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($transaction->items as $item)
        <tr>
          <td>{{ $item->name }}</td>
          <td>{{ $item->quantity }}</td>
          <td>{{ currency($item->price) }}</td>
          <td>{{ currency($item->total) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="section">
    <strong>Total:</strong> {{ currency($transaction->total) }}
  </div>
</body>
</html>
