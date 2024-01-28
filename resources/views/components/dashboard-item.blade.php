<!-- resources/views/components/dashboard-item.blade.php -->

@props(['name', 'link'])

<div class="bg-white w-full border p-4 rounded-md shadow hover:shadow-md transition duration-300 flex items-center justify-between">
    <span>{{ $name }}</span>
</div>
