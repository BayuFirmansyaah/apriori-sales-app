<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">
                    Association Rules Analysis
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $project->name }} • {{ $rules->total() }} rules discovered
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('reports.pdf', $project) }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-600 border border-red-600 rounded-lg font-medium text-sm text-white hover:bg-red-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF Report
                </a>
                <a href="{{ route('projects.show', $project) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Project
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Key Insights Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden rounded-xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Rules</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $rules->total() }}</p>
                                <p class="mt-1 text-xs text-gray-500">Association patterns found</p>
                            </div>
                            <div class="bg-blue-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden rounded-xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Min Support</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($project->min_support * 100, 1) }}%</p>
                                <p class="mt-1 text-xs text-gray-500">Threshold applied</p>
                            </div>
                            <div class="bg-purple-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden rounded-xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Min Confidence</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($project->min_confidence * 100, 1) }}%</p>
                                <p class="mt-1 text-xs text-gray-500">Reliability threshold</p>
                            </div>
                            <div class="bg-green-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden rounded-xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Transactions</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($project->transactions->count()) }}</p>
                                <p class="mt-1 text-xs text-gray-500">Data points analyzed</p>
                            </div>
                            <div class="bg-orange-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Rules by Support Chart -->
                <div class="bg-white overflow-hidden rounded-xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Top 10 Rules by Support</h3>
                                <p class="text-sm text-gray-600">Most frequently occurring patterns</p>
                            </div>
                            <div class="bg-blue-100 rounded-lg p-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="h-80">
                            <canvas id="supportChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Confidence vs Lift Scatter Plot -->
                <div class="bg-white overflow-hidden rounded-xl border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Confidence vs Lift</h3>
                                <p class="text-sm text-gray-600">Rule quality distribution</p>
                            </div>
                            <div class="bg-purple-100 rounded-lg p-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="h-80">
                            <canvas id="scatterChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item Frequency Pie Chart -->
            <div class="bg-white overflow-hidden rounded-xl border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Top 10 Most Frequent Items</h3>
                            <p class="text-sm text-gray-600">Items appearing most in association rules</p>
                        </div>
                        <div class="bg-green-100 rounded-lg p-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="h-96">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Insights Panel -->
            @if($rules->count() > 0)
                @php
                    $allRules = $project->rules;
                    $strongRules = $allRules->where('lift', '>', 1)->where('confidence', '>', 0.7);
                    $avgSupport = $allRules->avg('support');
                    $avgConfidence = $allRules->avg('confidence');
                    $avgLift = $allRules->avg('lift');
                    $topRule = $allRules->sortByDesc('lift')->first();
                @endphp
                
                <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                    <div class="p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-blue-900 mb-3">📊 Key Insights</h3>
                                <div class="space-y-3 text-sm text-blue-800">
                                    <div class="bg-white rounded-lg p-3">
                                        <p class="font-medium mb-1">🎯 Strong Associations Found</p>
                                        <p>{{ $strongRules->count() }} out of {{ $allRules->count() }} rules show strong positive correlation (Lift > 1, Confidence > 70%)</p>
                                    </div>
                                    
                                    <div class="bg-white rounded-lg p-3">
                                        <p class="font-medium mb-1">📈 Average Metrics</p>
                                        <ul class="list-disc list-inside space-y-1 ml-2">
                                            <li>Support: {{ number_format($avgSupport * 100, 2) }}% - Shows overall pattern frequency</li>
                                            <li>Confidence: {{ number_format($avgConfidence * 100, 2) }}% - Average rule reliability</li>
                                            <li>Lift: {{ number_format($avgLift, 2) }}x - {{ $avgLift > 1 ? 'Positive correlation on average' : 'Weak correlation detected' }}</li>
                                        </ul>
                                    </div>
                                    
                                    @if($topRule)
                                    <div class="bg-white rounded-lg p-3">
                                        <p class="font-medium mb-1">⭐ Strongest Rule</p>
                                        <p class="mb-2">
                                            <span class="font-semibold">IF</span> 
                                            @foreach($topRule->antecedent as $item)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-1">{{ $item }}</span>
                                            @endforeach
                                            <span class="font-semibold">THEN</span>
                                            @foreach($topRule->consequent as $item)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 mr-1">{{ $item }}</span>
                                            @endforeach
                                        </p>
                                        <p class="text-xs">Lift: {{ number_format($topRule->lift, 2) }}x | Confidence: {{ number_format($topRule->confidence * 100, 1) }}% | Support: {{ number_format($topRule->support * 100, 2) }}%</p>
                                    </div>
                                    @endif
                                    
                                    <div class="bg-white rounded-lg p-3">
                                        <p class="font-medium mb-1">💡 Actionable Recommendations</p>
                                        <ul class="list-disc list-inside space-y-1 ml-2">
                                            <li>Focus on rules with Lift > 1.5 for product bundling strategies</li>
                                            <li>High confidence rules (>80%) are reliable for cross-selling</li>
                                            <li>Consider shelf placement based on strong associations</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('apriori.results', $project) }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                            <select name="sort" id="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="lift_desc" {{ request('sort') == 'lift_desc' ? 'selected' : '' }}>Lift (High to Low)</option>
                                <option value="lift_asc" {{ request('sort') == 'lift_asc' ? 'selected' : '' }}>Lift (Low to High)</option>
                                <option value="confidence_desc" {{ request('sort') == 'confidence_desc' ? 'selected' : '' }}>Confidence (High to Low)</option>
                                <option value="confidence_asc" {{ request('sort') == 'confidence_asc' ? 'selected' : '' }}>Confidence (Low to High)</option>
                                <option value="support_desc" {{ request('sort') == 'support_desc' ? 'selected' : '' }}>Support (High to Low)</option>
                                <option value="support_asc" {{ request('sort') == 'support_asc' ? 'selected' : '' }}>Support (Low to High)</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="min_lift" class="block text-sm font-medium text-gray-700">Min Lift</label>
                            <input type="number" name="min_lift" id="min_lift" step="0.1" value="{{ request('min_lift') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search Item</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Search for item..."
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Rules Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Association Rules</h3>
                    
                    @if($rules->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            #
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Antecedent (IF)
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            →
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Consequent (THEN)
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Support
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Confidence
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Lift
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($rules as $index => $rule)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ ($rules->currentPage() - 1) * $rules->perPage() + $index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($rule->antecedent as $item)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $item }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center text-xl text-gray-400">→</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <div class="flex flex-wrap gap-1">
                                                    @foreach($rule->consequent as $item)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            {{ $item }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                                {{ number_format($rule->support, 4) }}
                                                <span class="text-xs text-gray-500">({{ number_format($rule->support * 100, 2) }}%)</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                                {{ number_format($rule->confidence, 4) }}
                                                <span class="text-xs text-gray-500">({{ number_format($rule->confidence * 100, 2) }}%)</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                                <span class="font-semibold {{ $rule->lift > 1 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ number_format($rule->lift, 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $rules->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No rules found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or run analysis again.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Interpretation Guide -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">How to Interpret</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>Support:</strong> Frequency of itemset appearance (higher = more common)</li>
                                <li><strong>Confidence:</strong> Likelihood of consequent when antecedent occurs (0-1 scale)</li>
                                <li><strong>Lift > 1:</strong> Items positively correlated (buy together)</li>
                                <li><strong>Lift = 1:</strong> Items independent (no relationship)</li>
                                <li><strong>Lift < 1:</strong> Items negatively correlated (rarely buy together)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <script>
        // Prepare data from Laravel
        const topRulesBySupport = @json($topRulesBySupport);
        const scatterData = @json($scatterData);
        const pieChartData = @json($pieChartData);
        
        // Helper function to truncate long labels
        function truncateLabel(label, maxLength = 30) {
            if (label.length <= maxLength) return label;
            return label.substring(0, maxLength) + '...';
        }
        
        // 1. Bar Chart - Top Rules by Support
        const supportCtx = document.getElementById('supportChart');
        if (supportCtx && topRulesBySupport.length > 0) {
            new Chart(supportCtx, {
                type: 'bar',
                data: {
                    labels: topRulesBySupport.map(r => truncateLabel(r.label, 25)),
                    datasets: [{
                        label: 'Support (%)',
                        data: topRulesBySupport.map(r => r.support),
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return topRulesBySupport[context[0].dataIndex].label;
                                },
                                label: function(context) {
                                    const rule = topRulesBySupport[context.dataIndex];
                                    return [
                                        `Support: ${rule.support}%`,
                                        `Confidence: ${rule.confidence}%`,
                                        `Lift: ${rule.lift}x`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Support (%)'
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45,
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // 2. Scatter Plot - Confidence vs Lift
        const scatterCtx = document.getElementById('scatterChart');
        if (scatterCtx && scatterData.length > 0) {
            new Chart(scatterCtx, {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Rules',
                        data: scatterData,
                        backgroundColor: function(context) {
                            const lift = context.parsed.y;
                            if (lift > 1.5) return 'rgba(34, 197, 94, 0.6)'; // green
                            if (lift > 1) return 'rgba(59, 130, 246, 0.6)';  // blue
                            return 'rgba(239, 68, 68, 0.6)'; // red
                        },
                        borderColor: function(context) {
                            const lift = context.parsed.y;
                            if (lift > 1.5) return 'rgba(34, 197, 94, 1)';
                            if (lift > 1) return 'rgba(59, 130, 246, 1)';
                            return 'rgba(239, 68, 68, 1)';
                        },
                        borderWidth: 1,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return scatterData[context[0].dataIndex].label;
                                },
                                label: function(context) {
                                    return [
                                        `Confidence: ${context.parsed.x}%`,
                                        `Lift: ${context.parsed.y}x`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom',
                            title: {
                                display: true,
                                text: 'Confidence (%)'
                            },
                            min: 0,
                            max: 100
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Lift'
                            },
                            min: 0
                        }
                    }
                }
            });
        }
        
        // 3. Pie Chart - Top Items
        const pieCtx = document.getElementById('pieChart');
        if (pieCtx && pieChartData.labels.length > 0) {
            // Generate colors
            const colors = [
                'rgba(59, 130, 246, 0.8)',   // blue
                'rgba(147, 51, 234, 0.8)',   // purple
                'rgba(34, 197, 94, 0.8)',    // green
                'rgba(234, 179, 8, 0.8)',    // yellow
                'rgba(239, 68, 68, 0.8)',    // red
                'rgba(236, 72, 153, 0.8)',   // pink
                'rgba(20, 184, 166, 0.8)',   // teal
                'rgba(249, 115, 22, 0.8)',   // orange
                'rgba(139, 92, 246, 0.8)',   // violet
                'rgba(6, 182, 212, 0.8)'     // cyan
            ];
            
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: pieChartData.labels,
                    datasets: [{
                        data: pieChartData.values,
                        backgroundColor: colors,
                        borderColor: colors.map(c => c.replace('0.8', '1')),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 11
                                },
                                generateLabels: function(chart) {
                                    const data = chart.data;
                                    if (data.labels.length && data.datasets.length) {
                                        return data.labels.map((label, i) => {
                                            const value = data.datasets[0].data[i];
                                            return {
                                                text: `${label} (${value})`,
                                                fillStyle: data.datasets[0].backgroundColor[i],
                                                hidden: false,
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} rules (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
