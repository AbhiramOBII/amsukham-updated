<!-- Track Order Modal -->
<div id="trackOrderModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-heritage-white rounded-lg shadow-2xl max-w-md w-full relative">
        <!-- Modal Header -->
        <div class="bg-deep-maroon text-heritage-white p-6 rounded-t-lg">
            <div class="flex items-center justify-between">
                <h3 class="font-serif text-2xl">Track Your Order</h3>
                <button onclick="closeTrackOrderModal()" class="text-heritage-white hover:text-royal-gold transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="text-heritage-white/80 text-sm mt-2">Enter your order number to track your shipment</p>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <form id="trackOrderForm" class="space-y-4">
                <div>
                    <label for="orderNumber" class="block text-sm font-medium text-deep-maroon mb-2">Order Number *</label>
                    <input 
                        type="text" 
                        id="orderNumber" 
                        name="order_number" 
                        required 
                        placeholder="e.g., ORD-2024-001234"
                        class="w-full px-4 py-3 border border-deep-maroon/20 rounded focus:border-royal-gold focus:outline-none bg-heritage-white text-deep-maroon"
                    >
                    <p class="text-xs text-deep-maroon/60 mt-1">You can find your order number in the confirmation email</p>
                </div>

                <div>
                    <label for="orderEmail" class="block text-sm font-medium text-deep-maroon mb-2">Email Address (Optional)</label>
                    <input 
                        type="email" 
                        id="orderEmail" 
                        name="email" 
                        placeholder="your@email.com"
                        class="w-full px-4 py-3 border border-deep-maroon/20 rounded focus:border-royal-gold focus:outline-none bg-heritage-white text-deep-maroon"
                    >
                </div>

                <!-- Error Message -->
                <div id="trackOrderError" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm"></div>

                <!-- Success Message -->
                <div id="trackOrderSuccess" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded text-sm"></div>

                <button 
                    type="submit" 
                    class="w-full bg-deep-maroon text-heritage-white px-6 py-3 rounded font-medium hover:bg-royal-gold hover:text-deep-maroon transition-colors shadow-lg"
                >
                    Track Order
                </button>
            </form>

            <!-- Order Status Display (Hidden by default) -->
            <div id="orderStatusDisplay" class="hidden mt-6 border-t border-deep-maroon/10 pt-6">
                <h4 class="font-serif text-lg text-deep-maroon mb-4">Order Status</h4>
                <div id="orderStatusContent"></div>
            </div>
        </div>
    </div>
</div>

<script>
function openTrackOrderModal() {
    const modal = document.getElementById('trackOrderModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeTrackOrderModal() {
    const modal = document.getElementById('trackOrderModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    
    // Reset form
    document.getElementById('trackOrderForm').reset();
    document.getElementById('trackOrderError').classList.add('hidden');
    document.getElementById('trackOrderSuccess').classList.add('hidden');
    document.getElementById('orderStatusDisplay').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('trackOrderModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeTrackOrderModal();
    }
});

// Handle form submission
document.getElementById('trackOrderForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const orderNumber = document.getElementById('orderNumber').value;
    const email = document.getElementById('orderEmail').value;
    const errorDiv = document.getElementById('trackOrderError');
    const successDiv = document.getElementById('trackOrderSuccess');
    const statusDisplay = document.getElementById('orderStatusDisplay');
    const statusContent = document.getElementById('orderStatusContent');
    
    // Hide previous messages
    errorDiv.classList.add('hidden');
    successDiv.classList.add('hidden');
    statusDisplay.classList.add('hidden');
    
    try {
        const response = await fetch('{{ route("order.track") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                order_number: orderNumber,
                email: email
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            // Show success message
            successDiv.textContent = 'Order found!';
            successDiv.classList.remove('hidden');
            
            // Display order status
            statusContent.innerHTML = `
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-deep-maroon/70">Order Number:</span>
                        <span class="font-medium text-deep-maroon">${data.order.order_number}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-deep-maroon/70">Status:</span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium ${getStatusColor(data.order.status)}">${data.order.status_label}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-deep-maroon/70">Order Date:</span>
                        <span class="font-medium text-deep-maroon">${data.order.order_date}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-deep-maroon/70">Total Amount:</span>
                        <span class="font-medium text-royal-gold">₹${data.order.total}</span>
                    </div>
                    ${data.order.tracking_number ? `
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-deep-maroon/70">Tracking Number:</span>
                        <span class="font-medium text-deep-maroon">${data.order.tracking_number}</span>
                    </div>
                    ` : ''}
                    <div class="mt-4 pt-4 border-t border-deep-maroon/10">
                        <a href="/orders/${data.order.id}" class="block w-full text-center bg-royal-gold text-deep-maroon px-4 py-2 rounded font-medium hover:bg-deep-maroon hover:text-heritage-white transition-colors">
                            View Full Order Details
                        </a>
                    </div>
                </div>
            `;
            statusDisplay.classList.remove('hidden');
        } else {
            errorDiv.textContent = data.message || 'Order not found. Please check your order number and try again.';
            errorDiv.classList.remove('hidden');
        }
    } catch (error) {
        errorDiv.textContent = 'An error occurred. Please try again later.';
        errorDiv.classList.remove('hidden');
    }
});

function getStatusColor(status) {
    const colors = {
        'pending': 'bg-yellow-100 text-yellow-800',
        'processing': 'bg-blue-100 text-blue-800',
        'shipped': 'bg-purple-100 text-purple-800',
        'delivered': 'bg-green-100 text-green-800',
        'cancelled': 'bg-red-100 text-red-800'
    };
    return colors[status] || 'bg-gray-100 text-gray-800';
}
</script>
