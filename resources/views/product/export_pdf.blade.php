<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Product Data Report</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px 5px 20px;
            line-height: 1.2; /* Adjusted line-height */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 4px 3px;
            border: 1px solid black; /* Added default border for visibility */
            vertical-align: top; /* Align text top */
        }
        th {
            text-align: left;
            background-color: #f2f2f2; /* Light grey background for headers */
        }
        .d-block {
            display: block;
        }
        img.logo { /* Changed class name for clarity */
            width: auto;
            height: 80px;
            max-width: 100px; /* Adjusted max-width */
            max-height: 80px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .p-1 {
            padding: 5px 1px 5px 1px;
        }
        .font-10 {
            font-size: 10pt;
        }
        .font-11 {
            font-size: 11pt;
        }
        .font-12 {
            font-size: 12pt;
        }
        .font-13 {
            font-size: 13pt;
        }
        .font-bold {
            font-weight: bold;
        }
        .mb-1 {
            margin-bottom: 0.25rem; /* Added margin */
        }
        .header-table {
            border: none; /* Remove border from header table */
            margin-bottom: 15px;
        }
        .header-table td {
            border: none; /* Remove border from header table cells */
            vertical-align: middle; /* Center logo vertically */
        }
        .data-table {
            border: 1px solid black;
        }
        .data-table th, .data-table td {
            border: 1px solid black;
        }
        /* Removed redundant styles from the original CSS block */
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td width="15%" class="text-center">
                {{-- Ensure 'polinema-bw.png' is in the public/ directory --}}
                <img src="{{ public_path('polinema-bw.png') }}" class="logo"> {{-- Use public_path for local assets in PDF --}}
            </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">MINISTRY OF EDUCATION, CULTURE, RESEARCH AND TECHNOLOGY</span>
                <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span> <mcreference link="http://www.polinema.ac.id" index="0">0</mcreference>
                <span class="text-center d-block font-10">Jl. Soekarno-Hatta No. 9 Malang 65141</span>
                <span class="text-center d-block font-10">Phone (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</span>
                <span class="text-center d-block font-10">Website: www.polinema.ac.id</span> <mcreference link="http://www.polinema.ac.id" index="0">0</mcreference>
            </td>
        </tr>
    </table>

    <hr style="border-top: 2px solid black; margin-bottom: 15px;">

    <h4 class="text-center" style="margin-bottom: 15px;">PRODUCT DATA REPORT</h4>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">Product Code</th>
                <th>Product Name</th>
                <th class="text-right" width="15%">Purchase Price</th>
                <th class="text-right" width="15%">Selling Price</th>
                <th width="20%">Category</th>
            </tr>
        </thead>
        <tbody>
            {{-- Renamed variable from $barang to $products for clarity --}}
            @forelse($products as $index => $product)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    {{-- Changed variable names to match ProductController --}}
                    <td>{{ $product->product_code }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td class="text-right">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                    {{-- Access category name via relationship --}}
                    <td>{{ $product->category->name_category }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No product data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
