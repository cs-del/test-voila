<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create editor user
        User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
            'role' => 'editor',
            'email_verified_at' => now(),
        ]);

        // Create regular user
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create 10 categories focused on programming
        $categories = [
            [
                'name' => 'Frontend Development',
                'slug' => 'frontend-development',
                'description' => 'Modern JavaScript frameworks, CSS techniques, and UI/UX best practices',
                'color' => '#3b82f6',
                'status' => 'active',
            ],
            [
                'name' => 'Backend Development',
                'slug' => 'backend-development',
                'description' => 'Server-side programming, APIs, databases, and microservices',
                'color' => '#10b981',
                'status' => 'active',
            ],
            [
                'name' => 'DevOps & Infrastructure',
                'slug' => 'devops-infrastructure',
                'description' => 'CI/CD pipelines, containerization, cloud deployment, and monitoring',
                'color' => '#8b5cf6',
                'status' => 'active',
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'iOS, Android, React Native, and cross-platform mobile applications',
                'color' => '#ef4444',
                'status' => 'active',
            ],
            [
                'name' => 'Database Management',
                'slug' => 'database-management',
                'description' => 'SQL, NoSQL, database design, optimization, and data modeling',
                'color' => '#f59e0b',
                'status' => 'active',
            ],
            [
                'name' => 'Security',
                'slug' => 'security',
                'description' => 'Cybersecurity, authentication, authorization, and secure coding practices',
                'color' => '#dc2626',
                'status' => 'active',
            ],
            [
                'name' => 'Performance Optimization',
                'slug' => 'performance-optimization',
                'description' => 'Code optimization, caching strategies, and performance monitoring',
                'color' => '#059669',
                'status' => 'active',
            ],
            [
                'name' => 'Testing & QA',
                'slug' => 'testing-qa',
                'description' => 'Unit testing, integration testing, automated testing, and quality assurance',
                'color' => '#7c3aed',
                'status' => 'active',
            ],
            [
                'name' => 'Software Architecture',
                'slug' => 'software-architecture',
                'description' => 'System design, architectural patterns, scalability, and best practices',
                'color' => '#db2777',
                'status' => 'active',
            ],
            [
                'name' => 'Tools & Frameworks',
                'slug' => 'tools-frameworks',
                'description' => 'Development tools, popular frameworks, libraries, and productivity tips',
                'color' => '#0891b2',
                'status' => 'active',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create 20+ articles
        $articles = [
            [
                'title' => 'The Complete Guide to React 18 and Concurrent Features',
                'slug' => 'react-18-concurrent-features-guide',
                'excerpt' => 'Discover the powerful concurrent features in React 18 that improve user experience with automatic batching, transitions, and Suspense improvements.',
                'content' => '<h1>🚀 Introduction to React 18 Concurrent Features</h1><p><strong>React 18 introduces several groundbreaking features</strong> that fundamentally change how we build user interfaces. The most significant addition is <em>concurrent features</em>, which allow React to prepare multiple versions of the UI simultaneously.</p><blockquote><p>"Concurrent features represent a fundamental change in how React handles rendering, enabling better user experiences through automatic batching, transitions, and improved Suspense."</p></blockquote><h2>🎯 What Are Concurrent Features?</h2><p>Concurrent features are a set of new capabilities that help React <span style="color: #3b82f6;">interrupt, pause, resume, or abandon</span> rendering work. This allows React to keep the UI responsive and maintain the illusion of simultaneity.</p><h3>🔑 Key Components</h3><ol><li><strong>Automatic Batching</strong><br><span style="color: #10b981;">Automatically groups multiple state updates</span> into a single render</li><li><strong>Transitions with useTransition</strong><br>Mark updates as transitions to keep applications responsive</li><li><strong>Suspense Improvements</strong><br>Enhanced support for data fetching and code splitting</li><li><strong>New Strict Mode Behaviors</strong><br>Additional warnings and development mode improvements</li><li><strong>Client/Server Rendering APIs</strong><br>Better support for SSR and streaming</li></ol><h3>💡 Quick Start Example</h3><pre><code>function App() {\n  const [isPending, startTransition] = useTransition();\n  const [query, setQuery] = useState(\'\');\n  \n  const filteredResults = useMemo(() => {\n    return expensiveFilterFunction(query);\n  }, [query]);\n  \n  const handleQueryChange = (value) => {\n    // Mark this update as a transition\n    startTransition(() => {\n      setQuery(value);\n    });\n  };\n}</code></pre><h2>⚡ Performance Benefits</h2><ul><li><strong>Faster initial renders</strong> - Critical updates happen immediately</li><li><strong>Smoother interactions</strong> - Non-urgent updates don\'t block user input</li><li><strong>Better responsiveness</strong> - UI remains interactive during heavy updates</li><li><strong>Reduced jank</strong> - Eliminates frame drops in complex applications</li></ul><p><a href="https://reactjs.org/docs/concurrent-features.html">Learn more about React Concurrent Features</a> in the official documentation.</p><h2>🔧 Implementation Tips</h2><p>Here are some <span style="background-color: #fef3c7; padding: 2px 4px;">best practices</span> when working with concurrent features:</p><ul><li>Use <code>useTransition</code> for non-urgent updates</li><li>Use <code>useDeferredValue</code> for deferred non-urgent values</li><li>Wrap expensive calculations in <code>useMemo</code></li><li>Consider using <code>Suspense</code> for data fetching</li></ul><p><strong>Remember:</strong> Concurrent features are opt-in, so you can adopt them gradually in your existing applications! 🎉</p>',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'user_id' => 1,
            ],
            [
                'title' => 'Building Scalable Microservices with Laravel and Docker',
                'slug' => 'scalable-microservices-laravel-docker',
                'excerpt' => 'Learn how to design and implement a microservices architecture using Laravel and Docker for better scalability and maintainability.',
                'content' => '<h1>🏗️ Building Scalable Microservices with Laravel and Docker</h1><p><strong>Microservices architecture</strong> has become the go-to approach for <em>building large-scale applications</em>. This guide walks you through implementing a <span style="color: #dc2626;">microservices architecture</span> with Laravel and Docker.</p><h2>📋 What We\'ll Cover</h2><p>We\'ll dive deep into service discovery, inter-service communication, data consistency, and deployment strategies that will help you build robust distributed systems.</p><div style="background-color: #f0f9ff; padding: 15px; border-left: 4px solid #3b82f6; margin: 20px 0;"><p><strong>💡 Pro Tip:</strong> Start with a monolithic application and gradually extract services as your understanding grows.</p></div><h2>🏛️ Architecture Components</h2><h3>Core Services</h3><ol><li><strong>API Gateway</strong> - Single entry point for all client requests</li><li><strong>Service Discovery</strong> - Dynamic service location and health checking</li><li><strong>Service Mesh</strong> - Inter-service communication and observability</li><li><strong>Container Orchestration</strong> - Docker container management</li><li><strong>Monitoring and Logging</strong> - Centralized observability</li></ol><h3>🔧 Infrastructure Components</h3><ul><li><span style="background-color: #fef3c7;">Load Balancers</span></li><li>Message Brokers (RabbitMQ, Kafka)</li><li>Database per service</li><li>Cache layers (Redis)</li><li>CI/CD Pipeline</li></ul><h2>💻 Implementation Example</h2><p>Here\'s a basic Docker Compose configuration:</p><pre><code>version: \'3.8\'\nservices:\n  api-gateway:\n    image: nginx:alpine\n    ports:\n      - "80:80"\n    depends_on:\n      - user-service\n      - order-service\n      - product-service\n  \n  user-service:\n    build: ./services/user-service\n    environment:\n      - DB_HOST=postgres\n      - DB_PORT=5432\n    depends_on:\n      - postgres\n  \n  postgres:\n    image: postgres:13\n    environment:\n      POSTGRES_DB: microservices\n      POSTGRES_USER: postgres\n      POSTGRES_PASSWORD: secret</code></pre><h2>🎯 Key Benefits</h2><blockquote><p>"Microservices enable independent scaling, deployment, and development of services, leading to faster time-to-market and better resource utilization."</p></blockquote><h2>⚠️ Common Pitfalls to Avoid</h2><ul><li><strong>Over-decomposition</strong> - Don\'t create too many services initially</li><li><strong>Data consistency</strong> - Plan for eventual consistency</li><li><strong>Network latency</strong> - Consider the cost of service calls</li><li><strong>Monitoring complexity</strong> - Invest in good observability from day one</li><li><strong>Version management</strong> - Plan for service versioning carefully</li></ul><p>Ready to get started? <a href="#getting-started">Jump to our getting started guide</a> or <a href="https://laravel.com/docs/microservices">read the Laravel documentation</a>.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(4),
                'user_id' => 2,
            ],
            [
                'title' => 'Kubernetes Best Practices for Production Environments',
                'slug' => 'kubernetes-best-practices-production',
                'excerpt' => 'Essential Kubernetes best practices for deploying and managing containerized applications in production.',
                'content' => '<p>Kubernetes has become the de facto standard for container orchestration. However, deploying applications to production requires careful consideration of security, scalability, and reliability.</p><p>This comprehensive guide covers everything from resource management to security policies, helping you build resilient Kubernetes deployments.</p><h3>Best Practices Covered</h3><ul><li>Resource Requests and Limits</li><li>Pod Disruption Budgets</li><li>Network Policies</li><li>Security Contexts</li><li>Monitoring and Alerting</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(6),
                'user_id' => 1,
            ],
            [
                'title' => 'Advanced TypeScript Patterns for Large-Scale Applications',
                'slug' => 'advanced-typescript-patterns-large-scale-apps',
                'excerpt' => 'Master advanced TypeScript patterns including conditional types, mapped types, and template literal types for building robust applications.',
                'content' => '<p>TypeScript has evolved far beyond simple type annotations. Modern TypeScript offers sophisticated type system features that can help you build more reliable and maintainable applications.</p><p>Learn how to leverage conditional types, mapped types, and template literal types to create type-safe APIs and improve developer experience.</p><h3>Advanced Patterns</h3><ul><li>Conditional Types</li><li>Mapped Types</li><li>Template Literal Types</li><li>Type Guards and Assertion Functions</li><li>Utility Types</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'user_id' => 2,
            ],
            [
                'title' => 'Database Performance Optimization: Indexing Strategies',
                'slug' => 'database-performance-optimization-indexing',
                'excerpt' => 'Learn effective database indexing strategies to improve query performance and reduce response times.',
                'content' => '<p>Database performance is crucial for application responsiveness. Proper indexing can mean the difference between a query taking milliseconds versus seconds.</p><p>This guide covers index types, query optimization techniques, and monitoring strategies to ensure your database performs optimally under load.</p><h3>Indexing Strategies</h3><ul><li>B-tree vs Hash Indexes</li><li>Composite Indexes</li><li>Partial Indexes</li><li>Query Plan Analysis</li><li>Index Maintenance</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'user_id' => 1,
            ],
            [
                'title' => 'Implementing OAuth 2.0 and JWT Authentication',
                'slug' => 'oauth2-jwt-authentication-implementation',
                'excerpt' => 'A comprehensive guide to implementing secure authentication using OAuth 2.0 and JWT tokens.',
                'content' => '<p>Security is paramount in modern web applications. OAuth 2.0 and JWT provide a robust foundation for authentication and authorization.</p><p>Learn how to implement these standards correctly, understand the flow differences, and avoid common security pitfalls.</p><h3>Implementation Topics</h3><ul><li>Authorization Code Flow</li><li>Refresh Tokens</li><li>Token Validation</li><li>Security Considerations</li><li>Best Practices</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'user_id' => 2,
            ],
            [
                'title' => 'React Native Performance Optimization Techniques',
                'slug' => 'react-native-performance-optimization',
                'excerpt' => 'Improve your React Native app performance with these proven optimization techniques and debugging strategies.',
                'content' => '<p>React Native apps can suffer from performance issues if not optimized properly. This guide covers memory management, rendering optimization, and debugging techniques.</p><p>Learn how to identify performance bottlenecks and implement solutions that provide a smooth user experience.</p><h3>Performance Techniques</h3><ul><li>Optimizing Re-renders</li><li>Memory Management</li><li>Image Optimization</li><li>Navigation Performance</li><li>Debugging Tools</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(14),
                'user_id' => 1,
            ],
            [
                'title' => 'Building Resilient APIs with Circuit Breaker Pattern',
                'slug' => 'resilient-apis-circuit-breaker-pattern',
                'excerpt' => 'Implement the Circuit Breaker pattern to build fault-tolerant APIs that can handle service failures gracefully.',
                'content' => '<h1>🔄 Building Resilient APIs with Circuit Breaker Pattern</h1><p><span style="color: #dc2626; font-size: 18px;"><strong>Modern applications rely heavily on external services and APIs</strong></span>. When these services fail, it can cascade and affect your entire application.</p><p>The <em>Circuit Breaker pattern</em> helps prevent this by detecting failures and providing fallback mechanisms. Learn how to implement this pattern effectively.</p><div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px; margin: 20px 0;"><h3 style="margin-top: 0; color: white;">🎯 What is a Circuit Breaker?</h3><p>A circuit breaker is a design pattern that prevents an application from repeatedly trying to execute an operation that\'s likely to fail, allowing it to continue without waiting for the fault to be fixed.</p></div><h2>⚙️ How It Works</h2><p>The circuit breaker acts as a proxy for operations that might fail. It monitors recent failures and, based on a configurable threshold, decides whether to allow the operation to proceed or return an error immediately.</p><h3>🔄 Circuit States</h3><div style="display: flex; gap: 10px; margin: 20px 0; flex-wrap: wrap;"><div style="background-color: #d1fae5; padding: 15px; border-radius: 8px; flex: 1; min-width: 200px;"><h4 style="margin-top: 0; color: #065f46;">✅ Closed State</h4><p>Normal operation. Requests pass through to the service.</p></div><div style="background-color: #fef3c7; padding: 15px; border-radius: 8px; flex: 1; min-width: 200px;"><h4 style="margin-top: 0; color: #92400e;">⚠️ Open State</h4><p>Failure threshold reached. Requests fail fast without calling the service.</p></div><div style="background-color: #e0f2fe; padding: 15px; border-radius: 8px; flex: 1; min-width: 200px;"><h4 style="margin-top: 0; color: #0c4a6e;">🔄 Half-Open State</h4><p>Testing if service has recovered. Limited requests allowed.</p></div></div><h2>💻 Implementation Example</h2><p>Here\'s a basic implementation using Laravel:</p><pre style="background-color: #1f2937; color: #f9fafb; padding: 20px; border-radius: 8px; overflow-x: auto;"><code>&lt;?php\n\nclass CircuitBreaker\n{\n    private $state = \'closed\';\n    private $failureCount = 0;\n    private $lastFailureTime;\n    \n    public function __construct(\n        private int $failureThreshold = 5,\n        private int $timeout = 60\n    ) {}\n    \n    public function call(callable $operation)\n    {\n        if ($this-&gt;isOpen()) {\n            if ($this-&gt;shouldAttemptReset()) {\n                $this-&gt;halfOpen();\n            } else {\n                throw new CircuitBreakerOpenException();\n            }\n        }\n        \n        try {\n            $result = $operation();\n            $this-&gt;onSuccess();\n            return $result;\n        } catch (Exception $e) {\n            $this-&gt;onFailure();\n            throw $e;\n        }\n    }\n    \n    private function onSuccess()\n    {\n        $this-&gt;failureCount = 0;\n        $this-&gt;state = \'closed\';\n    }\n    \n    private function onFailure()\n    {\n        $this-&gt;failureCount++;\n        $this-&gt;lastFailureTime = time();\n        \n        if ($this-&gt;failureCount &gt;= $this-&gt;failureThreshold) {\n            $this-&gt;state = \'open\';\n        }\n    }\n}</code></pre><h2>🎛️ Configuration Options</h2><table style="width: 100%; border-collapse: collapse; margin: 20px 0;"><tr style="background-color: #f3f4f6;"><th style="padding: 12px; text-align: left; border: 1px solid #d1d5db;">Parameter</th><th style="padding: 12px; text-align: left; border: 1px solid #d1d5db;">Description</th><th style="padding: 12px; text-align: left; border: 1px solid #d1d5db;">Default</th></tr><tr><td style="padding: 12px; border: 1px solid #d1d5db;"><code>failureThreshold</code></td><td style="padding: 12px; border: 1px solid #d1d5db;">Number of failures to open circuit</td><td style="padding: 12px; border: 1px solid #d1d5db;">5</td></tr><tr><td style="padding: 12px; border: 1px solid #d1d5db;"><code>timeout</code></td><td style="padding: 12px; border: 1px solid #d1d5db;">Time to wait before attempting reset (seconds)</td><td style="padding: 12px; border: 1px solid #d1d5db;">60</td></tr><tr><td style="padding: 12px; border: 1px solid #d1d5db;"><code>timeoutDuration</code></td><td style="padding: 12px; border: 1px solid #d1d5db;">Request timeout (milliseconds)</td><td style="padding: 12px; border: 1px solid #d1d5db;">3000</td></tr></table><h2>📊 Monitoring and Metrics</h2><p>Key metrics to monitor:</p><ul><li><strong>Success Rate</strong> - Percentage of successful requests</li><li><strong>Failure Rate</strong> - Percentage of failed requests</li><li><strong>Circuit State</strong> - Current state of each circuit breaker</li><li><strong>Response Time</strong> - Average response time when circuit is closed</li><li><strong>Fallback Rate</strong> - How often fallback methods are used</li></ul><blockquote><p><strong>💡 Best Practice:</strong> Always implement monitoring and alerting for your circuit breakers. They\'re only effective if you know when they\'re acting!</p></blockquote><h2>🚀 Next Steps</h2><ol><li>Implement circuit breakers for external API calls</li><li>Set up monitoring dashboards</li><li>Configure appropriate failure thresholds</li><li>Implement meaningful fallback strategies</li><li>Test failure scenarios thoroughly</li></ol><p>For more advanced implementations, check out libraries like <a href="https://github.com/oppian/circuitbreaker">Oppian Circuit Breaker</a> or <a href="https://resilience4j.readme.io/docs/circuitbreaker">Resilience4j</a>.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(16),
                'user_id' => 2,
            ],
            [
                'title' => 'Vue 3 Composition API vs Options API: When to Use What',
                'slug' => 'vue3-composition-api-vs-options-api',
                'excerpt' => 'Understand the differences between Vue 3 Composition API and Options API to make informed decisions about your project structure.',
                'content' => '<p>Vue 3 introduced the Composition API, offering a new way to build components. While it provides more flexibility, the Options API remains a solid choice for many projects.</p><p>Compare both approaches, understand their strengths and weaknesses, and learn when to use each one.</p><h3>Comparison Areas</h3><ul><li>Code Organization</li><li>Reusability</li><li>TypeScript Support</li><li>Learning Curve</li><li>Performance</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(18),
                'user_id' => 1,
            ],
            [
                'title' => 'Automated Testing Strategies: Unit, Integration, and E2E',
                'slug' => 'automated-testing-strategies-unit-integration-e2e',
                'excerpt' => 'Develop a comprehensive testing strategy that covers unit tests, integration tests, and end-to-end testing.',
                'content' => '<p>A robust testing strategy is essential for maintaining code quality and preventing regressions. Each type of test serves a different purpose and should be used strategically.</p><p>Learn how to structure your tests, choose the right testing tools, and create maintainable test suites.</p><h3>Testing Types</h3><ul><li>Unit Testing</li><li>Integration Testing</li><li>End-to-End Testing</li><li>Visual Regression Testing</li><li>Performance Testing</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(20),
                'user_id' => 2,
            ],
            [
                'title' => 'GraphQL vs REST: Choosing the Right API Architecture',
                'slug' => 'graphql-vs-rest-api-architecture',
                'excerpt' => 'Compare GraphQL and REST APIs to determine the best architecture for your next project.',
                'content' => '<p>API architecture decisions have long-term implications for your application. Both GraphQL and REST have their strengths and are suitable for different scenarios.</p><p>This guide helps you understand the trade-offs and choose the right approach for your specific use case.</p><h3>Comparison Factors</h3><ul><li>Performance</li><li>Caching</li><li>Development Speed</li><li>Client Requirements</li><li>Scalability</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(22),
                'user_id' => 1,
            ],
            [
                'title' => 'Implementing Event-Driven Architecture with Laravel',
                'slug' => 'event-driven-architecture-laravel',
                'excerpt' => 'Build scalable applications using event-driven architecture patterns with Laravel\'s built-in features.',
                'content' => '<p>Event-driven architecture helps build loosely coupled, scalable systems. Laravel provides excellent support for implementing this pattern.</p><p>Learn how to design events, implement listeners, and handle complex workflows using Laravel\'s event system.</p><h3>Architecture Components</h3><ul><li>Event Design</li><li>Event Listeners</li><li>Event Broadcasting</li><li>Queue Integration</li><li>Error Handling</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(24),
                'user_id' => 2,
            ],
            [
                'title' => 'Modern CSS Grid and Flexbox Layout Techniques',
                'slug' => 'modern-css-grid-flexbox-layout-techniques',
                'excerpt' => 'Master modern CSS layout techniques with Grid and Flexbox for creating responsive and dynamic layouts.',
                'content' => '<p>CSS has evolved significantly, offering powerful layout capabilities through Grid and Flexbox. These technologies have revolutionized how we approach web layout.</p><p>Learn advanced techniques for creating complex, responsive layouts that work across all devices and browsers.</p><h3>Layout Techniques</h3><ul><li>CSS Grid Areas</li><li>Flexbox Patterns</li><li>Responsive Design</li><li>Grid Auto-Placement</li><li>Subgrid and Container Queries</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(26),
                'user_id' => 1,
            ],
            [
                'title' => 'Server-Side Rendering vs Client-Side Rendering: Performance Analysis',
                'slug' => 'ssr-vs-csr-performance-analysis',
                'excerpt' => 'Compare Server-Side Rendering and Client-Side Rendering to understand performance implications and best use cases.',
                'content' => '<p>Rendering strategy significantly impacts application performance, SEO, and user experience. Understanding the trade-offs is crucial for making informed decisions.</p><p>Analyze real-world scenarios and performance metrics to determine the best rendering approach for your project.</p><h3>Performance Metrics</h3><ul><li>Time to First Byte</li><li>First Contentful Paint</li><li>Time to Interactive</li><li>Cumulative Layout Shift</li><li>Lighthouse Scores</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(28),
                'user_id' => 2,
            ],
            [
                'title' => 'Building Secure Web Applications: OWASP Top 10 Prevention',
                'slug' => 'secure-web-applications-owasp-top10',
                'excerpt' => 'Protect your web applications from common vulnerabilities following OWASP Top 10 security guidelines.',
                'content' => '<p>Web security is critical in today\'s digital landscape. The OWASP Top 10 represents the most critical web application security risks.</p><p>Learn how to prevent each vulnerability and implement security best practices in your development workflow.</p><h3>Security Topics</h3><ul><li>Injection Attacks</li><li>Broken Authentication</li><li>Sensitive Data Exposure</li><li>XML External Entities</li><li>Security Misconfiguration</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(30),
                'user_id' => 1,
            ],
            [
                'title' => 'Next.js 14: New Features and Performance Improvements',
                'slug' => 'nextjs14-new-features-performance',
                'excerpt' => 'Explore the latest features in Next.js 14, including the App Router improvements and performance enhancements.',
                'content' => '<p>Next.js 14 brings significant improvements to the React framework, including enhanced App Router capabilities and better performance optimization.</p><p>Discover how these new features can improve your development experience and application performance.</p><h3>New Features</h3><ul><li>Enhanced App Router</li><li>Improved Edge Runtime</li><li>Better Streaming</li><li>Optimized Images</li><li>Enhanced SEO</li></ul>',
                'status' => 'published',
                'published_at' => now()->subDays(32),
                'user_id' => 2,
            ],
            [
                'title' => 'PostgreSQL Advanced Query Optimization',
                'slug' => 'postgresql-advanced-query-optimization',
                'excerpt' => 'Master advanced PostgreSQL query optimization techniques for high-performance database applications.',
                'content' => '<p>PostgreSQL offers powerful optimization features that can dramatically improve query performance. Understanding these capabilities is essential for building scalable applications.</p><p>Learn advanced techniques including query planning, index optimization, and performance monitoring.</p><h3>Optimization Techniques</h3><ul><li>Query Plan Analysis</li><li>Index Strategies</li><li>Partitioning</li><li>Materialized Views</li><li>Query Caching</li></ul>',
                'status' => 'draft',
                'published_at' => null,
                'user_id' => 1,
            ],
            [
                'title' => 'WebSocket Implementation for Real-Time Applications',
                'slug' => 'websocket-implementation-realtime-applications',
                'excerpt' => 'Build real-time features in your web applications using WebSocket technology for instant communication.',
                'content' => '<p>WebSocket provides full-duplex communication between client and server, enabling real-time features like chat, notifications, and live updates.</p><p>Learn how to implement WebSocket connections, handle connections, and scale real-time applications.</p><h3>Implementation Topics</h3><ul><li>Connection Management</li><li>Message Broadcasting</li><li>Scalability Patterns</li><li>Security Considerations</li><li>Error Handling</li></ul>',
                'status' => 'draft',
                'published_at' => null,
                'user_id' => 2,
            ],
            [
                'title' => 'Laravel Queue System: Background Job Processing',
                'slug' => 'laravel-queue-system-background-jobs',
                'excerpt' => 'Implement reliable background job processing using Laravel\'s queue system for improved application performance.',
                'content' => '<p>Background job processing is essential for handling time-consuming tasks without blocking the user interface. Laravel provides a robust queue system for this purpose.</p><p>Learn how to configure queues, create jobs, handle failures, and monitor job processing.</p><h3>Queue Features</h3><ul><li>Job Creation</li><li>Queue Drivers</li><li>Failed Job Handling</li><li>Job Monitoring</li><li>Rate Limiting</li></ul>',
                'status' => 'draft',
                'published_at' => null,
                'user_id' => 1,
            ],
            [
                'title' => 'Building Progressive Web Apps: Service Workers and Caching',
                'slug' => 'progressive-web-apps-service-workers-caching',
                'excerpt' => 'Create offline-capable web applications using Service Workers and advanced caching strategies.',
                'content' => '<p>Progressive Web Apps (PWAs) bridge the gap between web and native applications, offering offline functionality and app-like experiences.</p><p>Learn how to implement Service Workers, design caching strategies, and create engaging PWA experiences.</p><h3>PWA Components</h3><ul><li>Service Workers</li><li>Web App Manifest</li><li>Caching Strategies</li><li>Offline Functionality</li><li>Push Notifications</li></ul>',
                'status' => 'draft',
                'published_at' => null,
                'user_id' => 2,
            ],
            [
                'title' => 'Docker Compose Best Practices for Development Workflows',
                'slug' => 'docker-compose-best-practices-development',
                'excerpt' => 'Optimize your development workflow using Docker Compose with best practices for local development environments.',
                'content' => '<p>Docker Compose simplifies local development by allowing you to define multi-container applications. However, to get the most benefit, you need to follow best practices.</p><p>Learn how to structure your Docker Compose files, manage environment variables, and optimize build performance.</p><h3>Best Practices</h3><ul><li>Environment Configuration</li><li>Volume Management</li><li>Network Configuration</li><li>Security Considerations</li><li>Performance Optimization</li></ul>',
                'status' => 'draft',
                'published_at' => null,
                'user_id' => 1,
            ],
        ];

        foreach ($articles as $articleData) {
            $article = Article::create($articleData);
            
            // Attach random categories to articles (1-3 categories per article)
            $categories = Category::all()->random(rand(1, 3));
            $article->categories()->attach($categories->pluck('id')->toArray());
        }

        // Create 20 realistic comments
        $comments = [
            ['name' => 'Alex Thompson', 'email' => 'alex.thompson@email.com', 'comment' => 'This React 18 guide is incredibly detailed! The concurrent features section really helped me understand the concepts better.', 'article_id' => 1, 'status' => 'approved'],
            ['name' => 'Sarah Chen', 'email' => 's.chen@devmail.com', 'comment' => 'Great article on microservices! I\'ve been struggling with service communication patterns, and this cleared things up for me.', 'article_id' => 2, 'status' => 'approved'],
            ['name' => 'Mike Rodriguez', 'email' => 'mike.rodriguez@techmail.com', 'comment' => 'The Kubernetes best practices article saved me hours of debugging. The resource limits section was particularly helpful.', 'article_id' => 3, 'status' => 'approved'],
            ['name' => 'Emily Johnson', 'email' => 'emily.j@webdev.net', 'comment' => 'Love the TypeScript patterns guide! The conditional types section is a game-changer for type-safe APIs.', 'article_id' => 4, 'status' => 'approved'],
            ['name' => 'David Kim', 'email' => 'david.kim@dbexpert.com', 'comment' => 'Database optimization made simple! The indexing strategies in this article improved our query performance by 80%.', 'article_id' => 5, 'status' => 'approved'],
            ['name' => 'Lisa Wang', 'email' => 'lisa.wang@securesys.org', 'comment' => 'Excellent security guide! The OAuth 2.0 implementation examples are crystal clear and well-explained.', 'article_id' => 6, 'status' => 'approved'],
            ['name' => 'James Miller', 'email' => 'j.miller@reactnative.dev', 'comment' => 'React Native performance tips were exactly what I needed! My app now runs much smoother after implementing these techniques.', 'article_id' => 7, 'status' => 'approved'],
            ['name' => 'Anna Petrov', 'email' => 'anna.petrov@api-arch.com', 'comment' => 'Circuit breaker pattern explained perfectly! We\'ve implemented this and it\'s made our API much more resilient.', 'article_id' => 8, 'status' => 'approved'],
            ['name' => 'Tom Wilson', 'email' => 'tom.wilson@vuejs.pro', 'comment' => 'Vue 3 composition API vs Options API comparison is spot-on. This helped our team make the right choice for our new project.', 'article_id' => 9, 'status' => 'approved'],
            ['name' => 'Rachel Green', 'email' => 'rachel.green@testqa.net', 'comment' => 'Testing strategy article is comprehensive! We\'ve restructured our entire testing approach based on these guidelines.', 'article_id' => 10, 'status' => 'approved'],
            ['name' => 'Carlos Mendez', 'email' => 'carlos@graphql.org', 'comment' => 'GraphQL vs REST comparison is very balanced. The performance analysis section helped us choose the right approach.', 'article_id' => 11, 'status' => 'approved'],
            ['name' => 'Sophie Turner', 'email' => 'sophie.turner@laravel.dev', 'comment' => 'Event-driven architecture with Laravel is brilliant! Our application is now much more maintainable and scalable.', 'article_id' => 12, 'status' => 'approved'],
            ['name' => 'John Park', 'email' => 'john.park@css-pro.com', 'comment' => 'CSS Grid and Flexbox guide is fantastic! The layout techniques section has improved my design workflow significantly.', 'article_id' => 13, 'status' => 'approved'],
            ['name' => 'Maria Garcia', 'email' => 'maria.garcia@web-perf.net', 'comment' => 'SSR vs CSR performance analysis was eye-opening! The real metrics and comparisons make it easy to understand.', 'article_id' => 14, 'status' => 'approved'],
            ['name' => 'Kevin Lee', 'email' => 'kevin.lee@security-first.com', 'comment' => 'OWASP Top 10 prevention guide is essential reading! Every developer should know these security practices.', 'article_id' => 15, 'status' => 'approved'],
            ['name' => 'Nina Patel', 'email' => 'nina.patel@nextjs.io', 'comment' => 'Next.js 14 features overview is exciting! Can\'t wait to try out the new App Router improvements.', 'article_id' => 16, 'status' => 'pending'],
            ['name' => 'Robert Brown', 'email' => 'rob.brown@postgres-expert.org', 'comment' => 'PostgreSQL optimization techniques are advanced but very useful. Looking forward to implementing these in our production database.', 'article_id' => 17, 'status' => 'pending'],
            ['name' => 'Amy Zhang', 'email' => 'amy.zhang@realtime-dev.com', 'comment' => 'WebSocket implementation guide is clear and practical. Real-time features have never been easier to implement!', 'article_id' => 18, 'status' => 'pending'],
            ['name' => 'Steve Cooper', 'email' => 'steve.cooper@laravel-pro.net', 'comment' => 'Laravel queue system article is comprehensive! Background job processing has improved our app\'s responsiveness greatly.', 'article_id' => 19, 'status' => 'pending'],
            ['name' => 'Jenny Liu', 'email' => 'jenny.liu@pwa-expert.com', 'comment' => 'Progressive Web Apps guide is excellent! Service Workers and caching strategies make offline functionality so much easier.', 'article_id' => 20, 'status' => 'pending'],
        ];

        foreach ($comments as $commentData) {
            Comment::create($commentData);
        }

        // Update some comments to different statuses
        Comment::whereIn('id', [1, 2, 3, 4, 5])->update(['status' => 'approved']);
        Comment::whereIn('id', [6, 7, 8, 9, 10])->update(['status' => 'approved']);
        Comment::whereIn('id', [11, 12, 13, 14, 15])->update(['status' => 'approved']);
        Comment::whereIn('id', [16, 17, 18, 19, 20])->update(['status' => 'pending']);

        // Create some contact messages
        Contact::create([
            'name' => 'Alice Johnson',
            'email' => 'alice.johnson@techcorp.com',
            'subject' => 'Partnership Opportunity',
            'message' => 'We are interested in discussing a potential partnership with your development team. Our company is looking for experts in Laravel and React development for our upcoming project.',
            'status' => 'new',
        ]);

        Contact::create([
            'name' => 'Mark Thompson',
            'email' => 'mark.thompson@startup.io',
            'subject' => 'Technical Consultation Request',
            'message' => 'Hi, I need consultation on implementing microservices architecture for our SaaS platform. Could we schedule a call to discuss your services and rates?',
            'status' => 'reviewed',
            'reviewed_at' => now()->subHours(2),
        ]);

        Contact::create([
            'name' => 'Sarah Williams',
            'email' => 'sarah.w@enterprise.org',
            'subject' => 'Training Program Inquiry',
            'message' => 'We are interested in organizing a training program for our development team focused on modern web technologies. Would you offer custom training sessions?',
            'status' => 'new',
        ]);

        Contact::create([
            'name' => 'David Chen',
            'email' => 'david.chen@freelance.net',
            'subject' => 'Freelance Collaboration',
            'message' => 'I\'m a freelance developer interested in collaborating on interesting projects. I specialize in React and Node.js. Let\'s discuss potential opportunities.',
            'status' => 'new',
        ]);
    }
}
