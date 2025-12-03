<!DOCTYPE html>
<html lang="en">

<head>
    <title>Payroll</title>
    @include('layout.head')
</head>

<body class="bg-gray-50">
    @include('layout.sidebar')

    <main class="md:ml-64 xl:ml-72 2xl:ml-72">
        @include('layout.navbar')
        <div class="p-5 space-y-4">

            <!-- Header & Add Button -->
            <h1>UMP</h1>
            <h1>tax</h1>
            <h1>bpjs</h1>
            <h1>UMP</h1>
            <h1>UMP</h1>


            <div
                class="flex justify-between items-center bg-gradient-to-l from-blue-100 to-blue-50 p-4 rounded-lg shadow">
                <h1 class="font-semibold text-2xl text-black">Setting</h1>

            </div>


        </div>
    </main>

    @include('sweetalert::alert')

</body>

</html>
