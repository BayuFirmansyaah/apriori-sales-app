<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $project->name }} - Analysis Report</title>
    <style>
        @page {
            margin: 1.5cm;
            size: A4 portrait;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 9pt;
            line-height: 1.5;
            color: #1a1a1a;
            padding: 15px;
        }
        
        @page {
            margin: 1.5cm;
        }
        
        /* Page Structure */
        .page-break {
            page-break-after: always;
        }
        
        .page-break-before {
            page-break-before: always;
        }
        
        /* Cover Page */
        .cover-page {
            text-align: center;
            padding: 180px 40px 40px 40px;
        }
        
        .cover-title {
            font-size: 28pt;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }
        
        .cover-subtitle {
            font-size: 16pt;
            color: #4b5563;
            margin-bottom: 50px;
            font-weight: 500;
        }
        
        .cover-type {
            font-size: 13pt;
            color: #1e40af;
            margin: 50px 0;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .cover-meta {
            font-size: 10pt;
            color: #6b7280;
            margin-top: 80px;
            line-height: 2;
        }
        
        .cover-meta strong {
            color: #374151;
        }
        
        /* Typography */
        h1 {
            font-size: 18pt;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 15px;
            margin-top: 25px;
            padding: 0 0 8px 0;
            border-bottom: 2px solid #1e40af;
        }
        
        h2 {
            font-size: 14pt;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 20px;
            margin-bottom: 12px;
            padding-left: 0;
        }
        
        h3 {
            font-size: 11pt;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 15px;
            margin-bottom: 8px;
            padding-left: 0;
        }
        
        p {
            margin-bottom: 8px;
            text-align: justify;
            padding: 0 5px;
        }
        
        strong {
            font-weight: 600;
            color: #1a1a1a;
        }
        
        /* Statistics Grid */
        .stats-container {
            margin: 20px 0;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            padding: 5px;
        }
        
        .stats-row {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        
        .stat-item {
            display: table-cell;
            width: 33.33%;
            padding: 25px 20px;
            text-align: center;
            border-right: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        
        .stat-item:last-child {
            border-right: none;
        }
        
        .stat-value {
            font-size: 24pt;
            font-weight: bold;
            color: #1e40af;
            display: block;
            margin-bottom: 6px;
        }
        
        .stat-label {
            font-size: 9pt;
            color: #4b5563;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-desc {
            font-size: 7pt;
            color: #9ca3af;
            margin-top: 3px;
        }
        
        /* Info Boxes */
        .info-box {
            padding: 15px 18px;
            margin: 12px 0;
            border-left: 4px solid #3b82f6;
            background: #eff6ff;
            border-radius: 0 4px 4px 0;
        }
        
        .info-box.success {
            border-left-color: #10b981;
            background: #ecfdf5;
        }
        
        .info-box.warning {
            border-left-color: #f59e0b;
            background: #fffbeb;
        }
        
        .info-box.info {
            border-left-color: #3b82f6;
            background: #eff6ff;
        }
        
        .info-box h3 {
            margin: 0 0 6px 0;
            font-size: 10pt;
            color: #1e3a8a;
        }
        
        .info-box p {
            margin: 0;
            font-size: 8.5pt;
            line-height: 1.6;
            color: #374151;
        }
        
        .metric-box {
            padding: 12px 15px;
            margin: 10px 0;
            background: #f9fafb;
            border-left: 3px solid #3b82f6;
            border-radius: 0 3px 3px 0;
        }
        
        .metric-label {
            font-weight: 600;
            color: #1e40af;
            font-size: 9pt;
        }
        
        .metric-value {
            color: #374151;
            font-size: 9pt;
        }
        
        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 8pt;
        }
        
        thead {
            background: #1e40af;
            color: white;
        }
        
        th {
            padding: 12px 10px;
            text-align: left;
            font-weight: 600;
            font-size: 8.5pt;
            letter-spacing: 0.3px;
        }
        
        td {
            padding: 10px 10px;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
        }
        
        tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        
        tbody tr:hover {
            background: #f3f4f6;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        /* Badges */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 7.5pt;
            font-weight: 600;
            margin: 1px 2px;
            white-space: nowrap;
        }
        
        .badge-primary {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }
        
        .badge-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }
        
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        /* Rule Cards */
        .rule-card {
            border: 1px solid #d1d5db;
            padding: 18px;
            margin: 15px 0;
            background: #ffffff;
            border-radius: 4px;
        }
        
        .rule-header {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .rule-number {
            font-size: 10pt;
            font-weight: bold;
            color: #1e40af;
        }
        
        .rule-section {
            margin: 12px 0;
            padding: 5px 0;
        }
        
        .rule-section-label {
            font-weight: 600;
            font-size: 8.5pt;
            color: #4b5563;
            margin-bottom: 6px;
        }
        
        .rule-metrics {
            margin-top: 15px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            display: table;
            width: 100%;
        }
        
        .rule-metric {
            display: table-cell;
            width: 33.33%;
            padding: 8px;
            text-align: center;
        }
        
        .rule-metric-label {
            font-size: 7.5pt;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .rule-metric-value {
            font-size: 10pt;
            font-weight: bold;
            color: #1e40af;
            margin-top: 3px;
        }
        
        .rule-insight {
            margin-top: 12px;
            padding: 12px 15px;
            background: #ecfdf5;
            border-radius: 3px;
            border-left: 3px solid #10b981;
        }
        
        .rule-insight-label {
            font-weight: 600;
            font-size: 8pt;
            color: #065f46;
            margin-bottom: 5px;
        }
        
        .rule-insight-text {
            font-size: 8pt;
            color: #047857;
            line-height: 1.5;
            margin: 0;
            padding: 0 3px;
        }
        
        /* Lists */
        ul, ol {
            margin: 10px 0 10px 20px;
            padding: 0;
        }
        
        li {
            margin: 6px 0;
            line-height: 1.6;
            font-size: 9pt;
        }
        
        /* Info Grid */
        .info-table {
            width: 100%;
            margin: 15px 0;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-row:nth-child(even) {
            background: #f9fafb;
        }
        
        .info-label {
            display: table-cell;
            width: 35%;
            padding: 12px 15px;
            font-weight: 600;
            color: #4b5563;
            font-size: 9pt;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-value {
            display: table-cell;
            padding: 12px 15px;
            color: #1f2937;
            font-size: 9pt;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-row:last-child .info-label,
        .info-row:last-child .info-value {
            border-bottom: none;
        }
        
        /* Section Container */
        .section {
            margin: 30px 0;
            padding: 0 5px;
        }
        
        .section-intro {
            margin: 15px 0;
            padding: 15px;
            background: #f9fafb;
            border-left: 3px solid #3b82f6;
            font-size: 9pt;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    
    <!-- COVER PAGE -->
    <div class="cover-page">
        <div class="cover-title">📊 Association Rules Analysis</div>
        <div class="cover-subtitle">{{ $project->name }}</div>
        <div class="cover-type">Apriori Algorithm Report</div>
        <div class="cover-meta">
            <p><strong>Generated:</strong> {{ now()->format('F d, Y') }}</p>
            <p><strong>Project Status:</strong> {{ ucfirst($project->status) }}</p>
            <p><strong>Total Rules:</strong> {{ $stats['total_rules'] }}</p>
        </div>
    </div>
    
    <div class="page-break"></div>
    
    <!-- EXECUTIVE SUMMARY -->
    <div class="section">
        <h1>📋 Executive Summary</h1>
        
        <div class="section-intro">
            This report presents a comprehensive analysis of <strong>{{ number_format($stats['total_transactions']) }} transactions</strong> 
            using the Apriori algorithm. The analysis discovered <strong>{{ $stats['total_rules'] }} association rules</strong> 
            that meet the specified minimum support and confidence thresholds.
            @if($stats['strong_rules'] > 0)
                Among these, <strong>{{ $stats['strong_rules'] }} rules ({{ number_format(($stats['strong_rules'] / $stats['total_rules']) * 100, 1) }}%)</strong> 
                are classified as strong and actionable for business decision-making.
            @endif
        </div>
        
        <div class="stats-container">
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-value">{{ $stats['total_rules'] }}</div>
                    <div class="stat-label">Total Rules</div>
                    <div class="stat-desc">Association patterns discovered</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ number_format($stats['total_transactions']) }}</div>
                    <div class="stat-label">Transactions</div>
                    <div class="stat-desc">Data points analyzed</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $stats['strong_rules'] }}</div>
                    <div class="stat-label">Strong Rules</div>
                    <div class="stat-desc">High confidence & lift</div>
                </div>
            </div>
        </div>
        
        <h2>Performance Metrics</h2>
        
        <div class="metric-box">
            <span class="metric-label">Average Lift:</span>
            <span class="metric-value">{{ number_format($stats['avg_lift'], 2) }}x</span>
            @if($stats['avg_lift'] > 1.5)
                <span style="color: #10b981; font-weight: 600;"> ✓ Excellent Performance</span>
            @elseif($stats['avg_lift'] > 1)
                <span style="color: #3b82f6; font-weight: 600;"> ✓ Good Performance</span>
            @else
                <span style="color: #ef4444; font-weight: 600;"> ⚠ Needs Improvement</span>
            @endif
        </div>
        
        <div class="metric-box">
            <span class="metric-label">Average Confidence:</span>
            <span class="metric-value">{{ number_format($stats['avg_confidence'] * 100, 2) }}%</span>
            <span style="color: #6b7280; font-size: 8pt;"> (Prediction reliability)</span>
        </div>
        
        <div class="metric-box">
            <span class="metric-label">Average Support:</span>
            <span class="metric-value">{{ number_format($stats['avg_support'] * 100, 2) }}%</span>
            <span style="color: #6b7280; font-size: 8pt;"> (Pattern frequency)</span>
        </div>
        
        <div class="metric-box">
            <span class="metric-label">Lift Range:</span>
            <span class="metric-value">{{ number_format($stats['min_lift'], 2) }} - {{ number_format($stats['max_lift'], 2) }}</span>
        </div>
    </div>
    
    <!-- KEY INSIGHTS -->
    <div class="section">
        <h2>💡 Key Insights & Analysis</h2>
        @foreach($insights as $insight)
            <div class="info-box {{ $insight['type'] }}">
                <h3>{{ $insight['title'] }}</h3>
                <p>{{ $insight['description'] }}</p>
            </div>
        @endforeach
    </div>
    
    <div class="page-break"></div>
    
    <!-- PROJECT INFORMATION -->
    <div class="section">
        <h1>🎯 Project Information</h1>
        
        <div class="info-table" style="display: table;">
            <div class="info-row">
                <div class="info-label">Project Name</div>
                <div class="info-value">{{ $project->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Description</div>
                <div class="info-value">{{ $project->description ?: 'No description provided' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Created Date</div>
                <div class="info-value">{{ $project->created_at->format('F d, Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Project Status</div>
                <div class="info-value"><strong>{{ ucfirst($project->status) }}</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Minimum Support</div>
                <div class="info-value">{{ $project->min_support }} ({{ number_format($project->min_support * 100, 1) }}%)</div>
            </div>
            <div class="info-row">
                <div class="info-label">Minimum Confidence</div>
                <div class="info-value">{{ $project->min_confidence }} ({{ number_format($project->min_confidence * 100, 1) }}%)</div>
            </div>
            <div class="info-row">
                <div class="info-label">Total Datasets</div>
                <div class="info-value">{{ $stats['total_datasets'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Total Transactions</div>
                <div class="info-value">{{ number_format($stats['total_transactions']) }}</div>
            </div>
        </div>
    </div>
    
    <!-- APRIORI ALGORITHM EXPLANATION -->
    <div class="section">
        <h2>📚 Understanding the Apriori Algorithm</h2>
        <p>
            The Apriori algorithm is a fundamental data mining technique used to discover association rules in transactional datasets. 
            It systematically identifies frequent itemsets (combinations of items that appear together) and generates rules describing 
            relationships between these items.
        </p>
        
        <h3>Key Metrics Explained</h3>
        
        <div class="info-box info">
            <h3>Support</h3>
            <p>
                Measures how frequently an itemset appears in the dataset. A support of 10% means the itemset appears in 10% of all transactions.
                Higher support indicates more common patterns.
            </p>
        </div>
        
        <div class="info-box info">
            <h3>Confidence</h3>
            <p>
                Indicates the likelihood that the consequent occurs when the antecedent is present. Ranges from 0 to 1 (0% to 100%).
                A confidence of 80% means that 80% of the time when customers buy the antecedent items, they also buy the consequent items.
            </p>
        </div>
        
        <div class="info-box info">
            <h3>Lift</h3>
            <p>
                Measures how much more likely the consequent is to occur with the antecedent compared to random chance.
                <strong>Lift > 1:</strong> Positive correlation (items frequently bought together). 
                <strong>Lift = 1:</strong> Independent (no relationship). 
                <strong>Lift < 1:</strong> Negative correlation (rarely bought together).
            </p>
        </div>
    </div>
    
    <div class="page-break"></div>
    
    <!-- TOP 5 STRONGEST RULES -->
    <div class="section">
        <h1>⭐ Top 5 Strongest Association Rules</h1>
        <p style="margin-bottom: 15px;">
            These rules demonstrate the highest lift values, indicating the strongest correlations between items in your dataset.
        </p>
        
        @foreach($topRules as $index => $rule)
            <div class="rule-card">
                <div class="rule-header">
                    <span class="rule-number">Rule #{{ $index + 1 }}</span>
                </div>
                
                <div class="rule-section">
                    <div class="rule-section-label">IF Customer Buys (Antecedent):</div>
                    <div>
                        @foreach($rule->antecedent as $item)
                            <span class="badge badge-primary">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
                
                <div class="rule-section">
                    <div class="rule-section-label">THEN They Will Also Buy (Consequent):</div>
                    <div>
                        @foreach($rule->consequent as $item)
                            <span class="badge badge-success">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
                
                <div class="rule-metrics">
                    <div class="rule-metric">
                        <div class="rule-metric-label">Support</div>
                        <div class="rule-metric-value">{{ number_format($rule->support * 100, 2) }}%</div>
                    </div>
                    <div class="rule-metric">
                        <div class="rule-metric-label">Confidence</div>
                        <div class="rule-metric-value">{{ number_format($rule->confidence * 100, 2) }}%</div>
                    </div>
                    <div class="rule-metric">
                        <div class="rule-metric-label">Lift</div>
                        <div class="rule-metric-value" style="color: #10b981;">{{ number_format($rule->lift, 2) }}x</div>
                    </div>
                </div>
                
                <div class="rule-insight">
                    <div class="rule-insight-label">💡 Business Insight</div>
                    <p class="rule-insight-text">
                        Customers purchasing {{ implode(' and ', array_slice($rule->antecedent, 0, 2)) }} 
                        are <strong>{{ number_format($rule->lift, 1) }}x more likely</strong> to also purchase 
                        {{ implode(' and ', array_slice($rule->consequent, 0, 2)) }}.
                        @if($rule->confidence > 0.8)
                            With a confidence of {{ number_format($rule->confidence * 100, 0) }}%, this rule is highly reliable for cross-selling strategies.
                        @elseif($rule->confidence > 0.6)
                            This pattern shows good reliability ({{ number_format($rule->confidence * 100, 0) }}% confidence) for product recommendations.
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="page-break"></div>
    
    <!-- DATA ANALYSIS TABLES -->
    <div class="section">
        <h1>📊 Data Analysis</h1>
        
        <h2>Top 10 Rules by Support</h2>
        <p style="margin-bottom: 10px;">Rules with the highest frequency across all transactions.</p>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 45%;">Rule</th>
                    <th class="text-right" style="width: 17%;">Support</th>
                    <th class="text-right" style="width: 17%;">Confidence</th>
                    <th class="text-right" style="width: 16%;">Lift</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topRulesBySupport as $index => $rule)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $rule['label'] }}</td>
                        <td class="text-right">{{ $rule['support'] }}%</td>
                        <td class="text-right">{{ $rule['confidence'] }}%</td>
                        <td class="text-right"><strong>{{ $rule['lift'] }}x</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <h2>Most Frequent Items in Rules</h2>
        <p style="margin-bottom: 10px;">Items that appear most often in discovered association rules.</p>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">#</th>
                    <th style="width: 50%;">Item Name</th>
                    <th class="text-right" style="width: 20%;">Frequency</th>
                    <th class="text-right" style="width: 20%;">Percentage</th>
                </tr>
            </thead>
            <tbody>
                @php $totalFreq = array_sum(array_values($topItems)); @endphp
                @foreach($topItems as $itemIndex => $frequency)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $itemIndex }}</td>
                        <td class="text-right">{{ $frequency }}</td>
                        <td class="text-right"><strong>{{ number_format(($frequency / $totalFreq) * 100, 1) }}%</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="page-break"></div>
    
    <!-- COMPLETE ASSOCIATION RULES -->
    <div class="section">
        <h1>📄 Complete Association Rules</h1>
        <p style="margin-bottom: 12px;">
            Complete list of all {{ $stats['total_rules'] }} discovered association rules, sorted by lift (highest to lowest).
        </p>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 30%;">Antecedent (IF)</th>
                    <th style="width: 30%;">Consequent (THEN)</th>
                    <th class="text-right" style="width: 12%;">Support</th>
                    <th class="text-right" style="width: 12%;">Confidence</th>
                    <th class="text-right" style="width: 11%;">Lift</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rules->take(40) as $index => $rule)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            @foreach($rule->antecedent as $item)
                                <span class="badge badge-primary">{{ $item }}</span>
                            @endforeach
                        </td>
                        <td>
                            @foreach($rule->consequent as $item)
                                <span class="badge badge-success">{{ $item }}</span>
                            @endforeach
                        </td>
                        <td class="text-right">{{ number_format($rule->support * 100, 2) }}%</td>
                        <td class="text-right">{{ number_format($rule->confidence * 100, 2) }}%</td>
                        <td class="text-right">
                            @if($rule->lift > 1.5)
                                <strong style="color: #10b981;">{{ number_format($rule->lift, 2) }}</strong>
                            @elseif($rule->lift > 1)
                                <strong style="color: #3b82f6;">{{ number_format($rule->lift, 2) }}</strong>
                            @else
                                <span style="color: #ef4444;">{{ number_format($rule->lift, 2) }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($rules->count() > 40)
            <p style="margin: 15px 0; text-align: center; color: #6b7280; font-style: italic; font-size: 8pt;">
                Showing top 40 of {{ $rules->count() }} total rules. View the complete list in the web dashboard at 
                <strong>{{ url('/') }}</strong>
            </p>
        @endif
    </div>
    
    <div class="page-break"></div>
    
    <!-- BUSINESS RECOMMENDATIONS -->
    <div class="section">
        <h1>💼 Business Recommendations</h1>
        
        <p style="margin-bottom: 15px;">
            Based on the association rules analysis, here are strategic recommendations to leverage these insights:
        </p>
        
        <div class="info-box success">
            <h3>1. Product Bundling Strategy</h3>
            <p>
                Create product bundles based on rules with <strong>Lift > 1.5</strong> and <strong>Confidence > 80%</strong>. 
                These combinations demonstrate strong customer purchase patterns and are ideal for promotional packages that can 
                increase average transaction value and customer satisfaction.
            </p>
        </div>
        
        <div class="info-box success">
            <h3>2. Cross-Selling Opportunities</h3>
            <p>
                Implement intelligent recommendation systems or train sales staff to suggest consequent items when customers 
                show interest in antecedent items. Focus on rules with high confidence scores to maximize conversion rates 
                and improve customer experience through relevant suggestions.
            </p>
        </div>
        
        <div class="info-box success">
            <h3>3. Store Layout Optimization</h3>
            <p>
                Arrange frequently associated items near each other in physical stores to encourage impulse purchases and 
                improve customer convenience. This strategy reduces shopping time and increases the likelihood of complementary 
                purchases based on discovered patterns.
            </p>
        </div>
        
        <div class="info-box success">
            <h3>4. Targeted Marketing Campaigns</h3>
            <p>
                Design promotional campaigns featuring strongly associated items together. Offer bundle discounts on item 
                combinations with high lift values. Use these insights for email marketing, social media ads, and in-store 
                promotions to drive sales of related products.
            </p>
        </div>
        
        <div class="info-box success">
            <h3>5. Inventory Management</h3>
            <p>
                Ensure adequate stock levels for items that frequently appear together in association rules. Prevent stockouts 
                of complementary products, as customers purchasing antecedent items will likely seek consequent items. This 
                improves customer satisfaction and prevents lost sales opportunities.
            </p>
        </div>
        
        <h2>Implementation Priority Framework</h2>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Priority</th>
                    <th style="width: 35%;">Rule Criteria</th>
                    <th style="width: 45%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong style="color: #dc2626;">High Priority</strong></td>
                    <td>Lift > 2.0 AND Confidence > 85%</td>
                    <td>Implement immediately in all channels</td>
                </tr>
                <tr>
                    <td><strong style="color: #f59e0b;">Medium Priority</strong></td>
                    <td>Lift > 1.5 AND Confidence > 70%</td>
                    <td>Test in pilot programs before full rollout</td>
                </tr>
                <tr>
                    <td><strong style="color: #3b82f6;">Low Priority</strong></td>
                    <td>Lift > 1.0 AND Confidence > 60%</td>
                    <td>Monitor and evaluate performance over time</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- METHODOLOGY -->
    <div class="section">
        <h2>🔬 Analysis Methodology</h2>
        
        <p style="margin-bottom: 12px;">
            This comprehensive analysis was conducted using the Apriori algorithm with carefully selected parameters 
            to ensure meaningful and actionable results:
        </p>
        
        <div class="info-table" style="display: table;">
            <div class="info-row">
                <div class="info-label">Algorithm Used</div>
                <div class="info-value">Apriori Association Rule Mining</div>
            </div>
            <div class="info-row">
                <div class="info-label">Minimum Support Threshold</div>
                <div class="info-value">
                    {{ number_format($project->min_support * 100, 1) }}% 
                    <span style="color: #6b7280; font-size: 8pt;">
                        (Only patterns in at least {{ number_format($project->min_support * 100, 1) }}% of transactions)
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Minimum Confidence Threshold</div>
                <div class="info-value">
                    {{ number_format($project->min_confidence * 100, 1) }}% 
                    <span style="color: #6b7280; font-size: 8pt;">
                        (Only rules with at least {{ number_format($project->min_confidence * 100, 1) }}% reliability)
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Dataset Size</div>
                <div class="info-value">{{ number_format($stats['total_transactions']) }} transactions analyzed</div>
            </div>
            <div class="info-row">
                <div class="info-label">Analysis Date</div>
                <div class="info-value">{{ now()->format('F d, Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Processing Status</div>
                <div class="info-value"><strong>{{ ucfirst($project->status) }}</strong></div>
            </div>
        </div>
        
        <h3>Quality Assurance</h3>
        <p>
            All rules presented in this report have been validated against the specified thresholds to ensure statistical 
            significance and business relevance. Rules with insufficient support or confidence have been automatically filtered out.
        </p>
    </div>
    
    <!-- CONCLUSION -->
    <div class="section">
        <h2>📝 Conclusion</h2>
        
        <p style="margin-bottom: 12px;">
            The Apriori association rules analysis has successfully identified <strong>{{ $stats['total_rules'] }} meaningful patterns</strong> 
            within {{ number_format($stats['total_transactions']) }} transactions. 
            @if($stats['strong_rules'] > 0)
                Of particular significance, <strong>{{ $stats['strong_rules'] }} strong rules</strong> 
                ({{ number_format(($stats['strong_rules'] / $stats['total_rules']) * 100, 1) }}% of all rules) 
                are ready for immediate business application with high confidence and lift values.
            @endif
        </p>
        
        <div class="info-box success">
            <h3>Key Opportunities Identified</h3>
            <p>
                This analysis reveals significant opportunities for business growth through:
            </p>
        </div>
        
        <ul style="margin: 10px 0 10px 25px; line-height: 2;">
            <li><strong>Revenue Growth:</strong> Strategic product bundling based on strong associations can increase average transaction value</li>
            <li><strong>Customer Experience:</strong> Intelligent product recommendations improve shopping satisfaction and convenience</li>
            <li><strong>Operational Efficiency:</strong> Optimized inventory management and store layouts reduce costs and prevent stockouts</li>
            <li><strong>Marketing ROI:</strong> Targeted campaigns based on actual purchase patterns increase conversion rates</li>
        </ul>
        
        <div class="info-box info">
            <h3>Next Steps</h3>
            <p>
                We recommend implementing the <strong>top priority rules</strong> (Lift > 2.0, Confidence > 85%) 
                within the next quarter. Establish performance metrics to monitor the impact of these implementations, 
                including:
            </p>
        </div>
        
        <ul style="margin: 8px 0 8px 25px;">
            <li>Average transaction value increase</li>
            <li>Cross-sell conversion rates</li>
            <li>Customer satisfaction scores</li>
            <li>Inventory turnover improvements</li>
        </ul>
        
        <p style="margin-top: 15px; padding: 12px; background: #eff6ff; border-left: 3px solid #3b82f6;">
            <strong>For ongoing analysis:</strong> Regularly refresh this analysis with new transaction data to identify 
            evolving patterns and seasonal trends. The web dashboard provides real-time access to updated rules and 
            interactive visualizations at <strong>{{ url('/') }}</strong>
        </p>
    </div>
    
    <!-- FOOTER -->
    <div style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #e5e7eb; text-align: center; font-size: 8pt; color: #6b7280;">
        <p style="margin: 5px 0;"><strong style="color: #1e40af;">Apriori Sales App</strong> - Association Rules Analysis Report</p>
        <p style="margin: 5px 0;">Generated on {{ now()->format('F d, Y H:i:s') }}</p>
        <p style="margin: 5px 0;">© {{ now()->year }} All Rights Reserved</p>
    </div>
    
</body>
</html>
