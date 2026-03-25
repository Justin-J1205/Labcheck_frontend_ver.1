@extends('layouts.app')

@section('content')
    <style>
        .info-box {
            background: white;
            padding: 30px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th {
            text-align: left;
            color: #94a3b8;
            padding: 15px 0;
            border-bottom: 2px solid #f1f5f9;
        }

        td {
            padding: 20px 0;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 500;
        }

        .btn-action {
            background: #0f172a;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>

    <div class="info-box">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h1 style="margin: 0;">Hydrochloric Acid (HCl)</h1>
                <p style="color: #64748b; max-width: 500px; line-height: 1.6;">It is a solution of hydrogen chloride gas
                    dissolved in water. One of the most common and powerful acids.</p>
            </div>

            {{-- Only Staff/Admin can see the Update button --}}
            @if (Auth::user()->role != 'student')
                <button class="btn-action">Update Stock</button>
            @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>In-Stock</th>
                    <th>Available</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hydrochloric Acid</td>
                    <td>50 ml</td>
                    <td>0</td>
                    <td style="color: #ef4444; font-weight: bold;">X</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
