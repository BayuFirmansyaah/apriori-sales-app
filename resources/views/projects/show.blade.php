<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('projects.edit', $project) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Edit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Project Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Project Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <span class="mt-1 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                @if($project->status === 'completed') bg-green-100 text-green-800
                                @elseif($project->status === 'processing') bg-yellow-100 text-yellow-800
                                @elseif($project->status === 'failed') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Created</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $project->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Minimum Support</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $project->min_support }} ({{ $project->min_support * 100 }}%)</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Minimum Confidence</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $project->min_confidence }} ({{ $project->min_confidence * 100 }}%)</p>
                        </div>
                        
                        @if($project->description)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500">Description</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $project->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex space-x-3">
                        @if($project->datasets->count() == 0)
                            <a href="{{ route('datasets.import', $project) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Import Data
                            </a>
                        @elseif($project->status === 'draft' || $project->status === 'failed')
                            <form method="POST" action="{{ route('apriori.analyze', $project) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Run Apriori Analysis
                                </button>
                            </form>
                        @elseif($project->status === 'processing')
                            <div class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </div>
                        @elseif($project->status === 'completed')
                            <a href="{{ route('apriori.results', $project) }}"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                View Results
                            </a>
                            <form method="POST" action="{{ route('apriori.analyze', $project) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Re-run Analysis
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-500">Datasets</h4>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $project->datasets->count() }}</p>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-500">Transactions</h4>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $project->transactions->count() }}</p>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-sm font-medium text-gray-500">Association Rules</h4>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $project->rules->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Top Rules -->
            @if($project->rules->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Association Rules (by Lift)</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Antecedent</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">→</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Consequent</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Support</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Confidence</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Lift</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($project->rules as $rule)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ implode(', ', $rule->antecedent) }}</td>
                                            <td class="px-6 py-4 text-center text-gray-400">→</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ implode(', ', $rule->consequent) }}</td>
                                            <td class="px-6 py-4 text-sm text-right text-gray-900">{{ number_format($rule->support, 3) }}</td>
                                            <td class="px-6 py-4 text-sm text-right text-gray-900">{{ number_format($rule->confidence, 3) }}</td>
                                            <td class="px-6 py-4 text-sm text-right font-semibold text-gray-900">{{ number_format($rule->lift, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($project->rules->count() >= 10)
                            <div class="mt-4 text-center">
                                <a href="{{ route('apriori.results', $project) }}" class="text-indigo-600 hover:text-indigo-900">
                                    View All Rules →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
