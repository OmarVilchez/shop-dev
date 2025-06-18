<x-layouts.admin>

{{--
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('admin.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.categories.index')">
            {{ __('Categories') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-900 uppercase dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Created At
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr class=" ">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $category->id }}
                </th>
                <td class="px-6 py-4">
                    {{ $category->name }}
                </td>
                <td class="px-6 py-4">
                    {{ Str::limit($category->description, 100, '...') }}
                </td>
                <td class="px-6 py-4">
                    {{ $category->created_at }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}


</x-layouts.admin>
