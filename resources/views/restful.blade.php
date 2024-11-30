<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria RESTful Client Interface</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body class="bg-gray-100">
    <div id="app" class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-2xl font-semibold text-gray-800">🍕 Pizzeria RESTful Client</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button @click="currentTab = 'categories'" :class="{'text-blue-600': currentTab === 'categories'}" class="px-3 py-2 rounded-md text-sm font-medium hover:text-blue-600">Categories</button>
                        <button @click="currentTab = 'pizzas'" :class="{'text-blue-600': currentTab === 'pizzas'}" class="px-3 py-2 rounded-md text-sm font-medium hover:text-blue-600">Pizzas</button>
                        <button @click="currentTab = 'menu'" :class="{'text-blue-600': currentTab === 'menu'}" class="px-3 py-2 rounded-md text-sm font-medium hover:text-blue-600">Menu Items</button>
                        <button @click="currentTab = 'orders'" :class="{'text-blue-600': currentTab === 'orders'}" class="px-3 py-2 rounded-md text-sm font-medium hover:text-blue-600">Orders</button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 px-4">

            <!-- Categories Tab -->
            <div v-if="currentTab === 'categories'" class="space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
                    <div>
                        <div class="flex space-x-4">
                            <button @click="showCategoryModal = true" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add Category</button>
                            <button @click="generatePdf('categories')" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Download Categories Report
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="category in categories" :key="category.id">
                                <td class="px-6 py-4 whitespace-nowrap">@{{ category.cname }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">€@{{ category.price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button @click="editCategory(category)" class="text-blue-600 hover:text-blue-900 mr-4">Edit</button>
                                    <button @click="deleteCategory(category.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pizzas Tab -->
            <div v-if="currentTab === 'pizzas'" class="space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Pizzas</h2>
                    <button @click="showPizzaModal = true" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add Pizza</button>
                </div>

                <!-- Add this to the top of each tab's content, just below the header -->
                <div class="mb-6 bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Generate PDF Report</h3>
                    <div class="space-y-4">

                        <!-- Pizzas Tab -->
                        <div class="flex items-center space-x-4">
                            <select v-model="selectedCategory" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-3 border ">
                                <option value="">All Categories</option>
                                <option v-for="category in categories" :key="category.id" :value="category.cname">
                                    @{{ category.cname }}
                                </option>
                            </select>
                            <button @click="generatePdf('pizzas')" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Download Pizzas Report
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vegetarian</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="pizza in pizzas" :key="pizza.id">
                                <td class="px-6 py-4 whitespace-nowrap">@{{ pizza.pname }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">@{{ pizza.category_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">@{{ pizza.vegetarian ? 'Yes' : 'No' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button @click="editPizza(pizza)" class="text-blue-600 hover:text-blue-900 mr-4">Edit</button>
                                    <button @click="deletePizza(pizza.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Orders Tab -->
            <div v-if="currentTab === 'orders'" class="space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Orders</h2>
                </div>

                <div class="mb-6 bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Generate PDF Report</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-6">
                            <input type="date" v-model="startDate" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-1.5 border">
                            <input type="date" v-model="endDate" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-1.5 border">
                            <button @click="generatePdf('orders')" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Download Orders Report
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pizza</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="order in orders" :key="order.id">
                                <td class="px-6 py-4 whitespace-nowrap">#@{{ order.id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">@{{ order.pizza?.pname }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">@{{ order.quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="{
                                        'px-2 py-1 rounded-full text-xs font-medium': true,
                                        'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                        'bg-blue-100 text-blue-800': order.status === 'preparing',
                                        'bg-purple-100 text-purple-800': order.status === 'dispatched',
                                        'bg-green-100 text-green-800': order.status === 'delivered',
                                        'bg-red-100 text-red-800': order.status === 'cancelled'
                                    }">
                                        @{{ order.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">$@{{ order.total_price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button @click="updateOrderStatus(order)" class="text-blue-600 hover:text-blue-900 mr-4">Update Status</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div v-if="currentTab === 'menu'" class="space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Menu Items</h2>
                    <button @click="showMenuItemModal = true" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add Menu Item</button>
                </div>

                <div class="bg-white shadow rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Available</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="menuItem in menuItems" :key="menuItem.id">
                                <td class="px-6 py-4 whitespace-nowrap">@{{ menuItem.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">@{{ menuItem.is_available ? 'Yes' : 'No' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <button
                                        @click="toggleMenuItemAvailability(menuItem)"
                                        class="text-sm text-blue-600 hover:text-blue-900 mr-6">
                                        Toggle Availability
                                    </button>
                                    <button @click="editMenuItem(menuItem)" class="text-blue-600 hover:text-blue-900 mr-4">Edit</button>
                                    <button @click="deleteMenuItem(menuItem.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Category Modal -->
        <div v-if="showCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">@{{ editingCategory ? 'Edit Category' : 'Add Category' }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" v-model="categoryForm.cname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" v-model="categoryForm.price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button @click="showCategoryModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 border rounded-md">Cancel</button>
                        <button @click="saveCategory" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pizza Modal -->
        <div v-if="showPizzaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">@{{ editingPizza ? 'Edit Pizza' : 'Add Pizza' }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" v-model="pizzaForm.pname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select v-model="pizzaForm.category_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option v-for="category in categories" :key="category.id" :value="category.cname">
                                @{{ category.cname }}
                            </option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" v-model="pizzaForm.vegetarian" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <label class="ml-2 block text-sm text-gray-900">Vegetarian</label>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button @click="showPizzaModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 border rounded-md">Cancel</button>
                        <button @click="savePizza" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Item Modal -->
        <div v-if="showMenuItemModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">@{{ editingMenuItem ? 'Edit Menu Item' : 'Add Menu Item' }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" v-model="menuItemForm.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" v-model="menuItemForm.is_available" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <label class="ml-2 block text-sm text-gray-900">Is Available</label>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button @click="showMenuItemModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 border rounded-md">Cancel</button>
                        <button @click="saveMenuItem" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add this script tag just before the closing </body> tag
        const {
            createApp,
            ref
        } = Vue;

        // Configure Axios defaults
        axios.defaults.baseURL = '/api';
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['Accept'] = 'application/json';

        // Add CSRF token to all requests if using Laravel's CSRF protection
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (token) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        }

        const app = createApp({
            data() {
                return {
                    currentTab: 'categories',
                    categories: [],
                    pizzas: [],
                    orders: [],
                    menuItems: [],
                    showCategoryModal: false,
                    showPizzaModal: false,
                    showMenuItemModal: false,
                    editingCategory: null,
                    editingPizza: null,
                    editingMenuItem: null,
                    categoryForm: {
                        cname: '',
                        price: 0
                    },
                    pizzaForm: {
                        pname: '',
                        category_name: '',
                        vegetarian: false
                    },
                    menuItemForm: {
                        name: '',
                        available: true,
                    },
                    selectedCategory: '',
                    startDate: '',
                    endDate: '',
                }
            },
            watch: {
                // Watch for tab changes to reload data
                currentTab(newTab) {
                    this.loadTabData(newTab);
                }
            },
            methods: {
                // Load data based on current tab
                async loadTabData(tab) {
                    switch (tab) {
                        case 'categories':
                            await this.fetchCategories();
                            break;
                        case 'pizzas':
                            await this.fetchPizzas();
                            break;
                        case 'menu':
                            await this.fetchMenuItems();
                            break;
                        case 'orders':
                            await this.fetchOrders();
                            break;
                    }
                },

                // Categories
                async fetchCategories() {
                    try {
                        const response = await axios.get('/categories');
                        this.categories = response.data.data || response.data;
                        console.log('Categories loaded:', this.categories);
                    } catch (error) {
                        console.error('Error fetching categories:', error.response?.data || error);
                        alert('Error loading categories. Check console for details.');
                    }
                },
                async saveCategory() {
                    try {
                        if (this.editingCategory) {
                            await axios.put(`/categories/${this.editingCategory.id}`, this.categoryForm);
                        } else {
                            await axios.post('/categories', this.categoryForm);
                        }
                        await this.fetchCategories();
                        this.showCategoryModal = false;
                        this.resetCategoryForm();
                    } catch (error) {
                        console.error('Error saving category:', error.response?.data || error);
                        alert('Error saving category. Check console for details.');
                    }
                },
                async deleteCategory(id) {
                    if (confirm('Are you sure you want to delete this category?')) {
                        try {
                            await axios.delete(`/categories/${id}`);
                            await this.fetchCategories();
                        } catch (error) {
                            console.error('Error deleting category:', error.response?.data || error);
                            alert('Error deleting category. Check console for details.');
                        }
                    }
                },
                editCategory(category) {
                    this.editingCategory = category;
                    this.categoryForm = {
                        cname: category.cname,
                        price: category.price
                    };
                    this.showCategoryModal = true;
                },
                resetCategoryForm() {
                    this.categoryForm = {
                        cname: '',
                        price: 0
                    };
                    this.editingCategory = null;
                },

                // Pizzas
                async fetchPizzas() {
                    try {
                        const response = await axios.get('/pizzas');
                        this.pizzas = response.data.data || response.data;
                        console.log('Pizzas loaded:', this.pizzas);
                    } catch (error) {
                        console.error('Error fetching pizzas:', error.response?.data || error);
                        alert('Error loading pizzas. Check console for details.');
                    }
                },
                async savePizza() {
                    try {
                        if (this.editingPizza) {
                            await axios.put(`/pizzas/${this.editingPizza.id}`, this.pizzaForm);
                        } else {
                            await axios.post('/pizzas', this.pizzaForm);
                        }
                        await this.fetchPizzas();
                        this.showPizzaModal = false;
                        this.resetPizzaForm();
                    } catch (error) {
                        console.error('Error saving pizza:', error.response?.data || error);
                        alert('Error saving pizza. Check console for details.');
                    }
                },
                async deletePizza(id) {
                    if (confirm('Are you sure you want to delete this pizza?')) {
                        try {
                            await axios.delete(`/pizzas/${id}`);
                            await this.fetchPizzas();
                        } catch (error) {
                            console.error('Error deleting pizza:', error.response?.data || error);
                            alert('Error deleting pizza. Check console for details.');
                        }
                    }
                },
                editPizza(pizza) {
                    this.editingPizza = pizza;
                    this.pizzaForm = {
                        pname: pizza.pname,
                        category_name: pizza.category_name,
                        vegetarian: pizza.vegetarian
                    };
                    this.showPizzaModal = true;
                },
                resetPizzaForm() {
                    this.pizzaForm = {
                        pname: '',
                        category_name: '',
                        vegetarian: false
                    };
                    this.editingPizza = null;
                },

                // Menu Items
                async fetchMenuItems() {
                    try {
                        const response = await axios.get('/menu-items');
                        this.menuItems = response.data.data || response.data;
                        console.log('Menu items loaded:', this.menuItems);
                    } catch (error) {
                        console.error('Error fetching menu items:', error.response?.data || error);
                        alert('Error loading menu items. Check console for details.');
                    }
                },
                async saveMenuItem() {
                    try {
                        if (this.editingMenuItem) {
                            await axios.put(`/menu-items/${this.editingMenuItem.id}`, this.menuItemForm);
                        } else {
                            await axios.post('/menu-items', this.menuItemForm);
                        }
                        await this.fetchMenuItems();
                        this.showMenuItemModal = false;
                        this.resetMenuItemForm();
                    } catch (error) {
                        console.error('Error saving menu item:', error.response?.data || error);
                        alert('Error saving menu item. Check console for details.');
                    }
                },
                async deleteMenuItem(id) {
                    if (confirm('Are you sure you want to delete this menu item?')) {
                        try {
                            await axios.delete(`/menu-items/${id}`);
                            await this.fetchMenuItems();
                        } catch (error) {
                            console.error('Error deleting menu item:', error.response?.data || error);
                            alert('Error deleting menu item. Check console for details.');
                        }
                    }
                },
                editMenuItem(menuItem) {
                    this.editingMenuItem = menuItem;
                    this.menuItemForm = {
                        name: menuItem.name,
                        is_available: menuItem.is_available
                    };
                    this.showMenuItemModal = true;
                },
                resetMenuItemForm() {
                    this.menuItemForm = {
                        name: '',
                        is_available: true
                    };
                    this.editingMenuItem = null;
                },
                async toggleMenuItemAvailability(menuItem) {
                    try {
                        await axios.put(`/menu-items/${menuItem.id}/toggle`);
                        await this.fetchMenuItems();
                    } catch (error) {
                        console.error('Error toggling menu item availability:', error.response?.data || error);
                        alert('Error updating menu item. Check console for details.');
                    }
                },

                // Orders
                async fetchOrders() {
                    try {
                        const response = await axios.get('/orders');
                        this.orders = response.data.data || response.data;
                        console.log('Orders loaded:', this.orders);
                    } catch (error) {
                        console.error('Error fetching orders:', error.response?.data || error);
                        alert('Error loading orders. Check console for details.');
                    }
                },
                async updateOrderStatus(order) {
                    if (confirm('Are you sure you want to update the order status?')) {
                        const statuses = ['pending', 'preparing', 'dispatched', 'delivered', 'cancelled'];
                        const currentIndex = statuses.indexOf(order.status);
                        const nextStatus = statuses[(currentIndex + 1) % statuses.length];

                        try {
                            await axios.put(`/orders/${order.id}/status`, {
                                status: nextStatus
                            });
                            await this.fetchOrders();
                        } catch (error) {
                            console.error('Error updating order status:', error.response?.data || error);
                            alert('Error updating order status. Check console for details.');
                        }
                    }
                },

                async generatePdf(reportType) {
                    try {
                        // Validate inputs for orders report
                        if (reportType === 'orders' && (!this.startDate || !this.endDate)) {
                            alert('Please select both start and end dates');
                            return;
                        }

                        // Create form data
                        const formData = new FormData();
                        formData.append('report_type', reportType);

                        if (reportType === 'orders') {
                            formData.append('start_date', this.startDate);
                            formData.append('end_date', this.endDate);
                        } else if (reportType === 'pizzas' && this.selectedCategory) {
                            formData.append('category', this.selectedCategory);
                        }

                        // Make request
                        const response = await axios.post('/generate-pdf', formData, {
                            responseType: 'blob'
                        });

                        // Create download link
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', `pizzeria-${reportType}-report.pdf`);
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                        window.URL.revokeObjectURL(url);
                    } catch (error) {
                        console.error('Error generating PDF:', error);
                        alert('Error generating PDF. Please check console for details.');
                    }
                }

            },
            mounted() {
                // Load initial data for the current tab
                this.loadTabData(this.currentTab);
            }
        }).mount('#app');
    </script>

</body>

</html>