<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP Client</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/xml.min.js"></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">
    <div x-data="soapTester()" class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">SOAP API Tester</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Available Operations</h2>

                    @foreach($operations as $category => $methods)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-700 mb-2">{{ $category }}</h3>
                        <div class="space-y-2">
                            @foreach($methods as $method => $params)
                            <button
                                @click="selectMethod('{{ $method }}', {{ json_encode($params) }})"
                                class="w-full text-left px-4 py-2 rounded-md text-sm"
                                :class="selectedMethod === '{{ $method }}' ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100 text-gray-600'">
                                {{ $method }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Request Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Request</h2>

                    <form @submit.prevent="executeRequest" x-show="selectedMethod" class="space-y-6">
                        <template x-for="param in selectedParams" :key="param">
                            <div>
                                <label :for="param" class="block text-sm font-medium text-gray-700 mb-1" x-text="param"></label>
                                <input
                                    :type="param.includes('price') || param.includes('id') || param.includes('quantity') ? 'number' : 'text'"
                                    :name="param"
                                    :id="param"
                                    class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :required="true">
                            </div>
                        </template>

                        <div class="flex justify-end">
                            <button
                                type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Execute Request
                            </button>
                        </div>
                    </form>

                    <div x-show="!selectedMethod" class="text-gray-500 text-center py-8">
                        Select an operation from the left panel to begin
                    </div>
                </div>

                <!-- Response Section -->
                <template x-if="response">
                    <div class="space-y-6">
                        <!-- Result -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Result</h3>
                            <pre x-show="response.success" class="bg-gray-50 p-4 rounded-md"><code class="language-json" x-text="JSON.stringify(response.result, null, 2)"></code></pre>
                            <div x-show="!response.success" class="text-red-600" x-text="response.error"></div>
                        </div>

                        <!-- Raw Request -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Raw Request</h3>
                            <pre><code class="language-xml" x-text="response.request"></code></pre>
                        </div>

                        <!-- Raw Response -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Raw Response</h3>
                            <pre><code class="language-xml" x-text="response.response"></code></pre>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function soapTester() {
            return {
                selectedMethod: '',
                selectedParams: [],
                response: null,

                selectMethod(method, params) {
                    this.selectedMethod = method;
                    this.selectedParams = params;
                    this.response = null;
                },

                async executeRequest(e) {
                    const formData = new FormData(e.target);
                    formData.append('method', this.selectedMethod);

                    try {
                        const response = await fetch('/soap/execute', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        this.response = await response.json();

                        // Highlight code blocks
                        this.$nextTick(() => {
                            document.querySelectorAll('pre code').forEach((block) => {
                                hljs.highlightBlock(block);
                            });
                        });
                    } catch (error) {
                        console.error('Error:', error);
                        this.response = {
                            success: false,
                            error: 'Failed to execute request'
                        };
                    }
                }
            }
        }
    </script>
</body>

</html>