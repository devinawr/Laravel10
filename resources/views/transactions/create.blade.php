@extends('layouts.adminlte4')
@section('title', 'Create Transaction')
@section('sidebar-transaction', 'active')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3>Create New Transaction</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('user_id') is-invalid @enderror" 
                                               id="user_id" name="user_id" value="{{ old('user_id') }}" 
                                               placeholder="Enter user ID" required>
                                        @error('user_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="doctor_id" class="form-label">Doctor <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('doctor_id') is-invalid @enderror" 
                                               id="doctor_id" name="doctor_id" value="{{ old('doctor_id') }}" 
                                               placeholder="Enter doctor ID" required>
                                        @error('doctor_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="transaction_date" class="form-label">Transaction Date & Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control @error('transaction_date') is-invalid @enderror" 
                                               id="transaction_date" name="transaction_date" value="{{ old('transaction_date') }}" required>
                                        @error('transaction_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                            <option value="">-- Select Status --</option>
                                            <option value="pending" @if(old('status') == 'pending') selected @endif>Pending</option>
                                            <option value="completed" @if(old('status') == 'completed') selected @endif>Completed</option>
                                            <option value="cancelled" @if(old('status') == 'cancelled') selected @endif>Cancelled</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h4 class="mb-3">Services <span class="text-danger">*</span></h4>

                            <div id="servicesContainer">
                                <div class="service-item mb-3">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <label class="form-label">Service</label>
                                            <select class="form-control service-select" name="services[]" required>
                                                <option value="">-- Select Service --</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                                        {{ $service->service_name }} - ${{ $service->price }} 
                                                        ({{ $service->category->category_name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Quantity</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control quantity-input" name="quantities[]" 
                                                       value="1" min="1" required>
                                                <button class="btn btn-danger btn-remove-service" type="button" style="display:none;">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="addServiceBtn" class="btn btn-sm btn-secondary mb-3">
                                <i class="fas fa-plus"></i> Add Another Service
                            </button>

                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Total Amount: <span id="totalAmount" class="text-success font-weight-bold">$0.00</span></h5>
                                </div>
                            </div>
                            <hr>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create Transaction</button>
                                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let serviceCount = 1;

        // Add service row
        document.getElementById('addServiceBtn').addEventListener('click', function() {
            const container = document.getElementById('servicesContainer');
            const newServiceItem = document.querySelector('.service-item').cloneNode(true);
            
            // Reset values
            newServiceItem.querySelector('.service-select').value = '';
            newServiceItem.querySelector('.quantity-input').value = '1';
            newServiceItem.querySelector('.btn-remove-service').style.display = 'block';
            
            // Add remove functionality
            newServiceItem.querySelector('.btn-remove-service').addEventListener('click', function() {
                newServiceItem.remove();
                calculateTotal();
            });

            // Add change listener for service select
            newServiceItem.querySelector('.service-select').addEventListener('change', calculateTotal);
            newServiceItem.querySelector('.quantity-input').addEventListener('change', calculateTotal);

            container.appendChild(newServiceItem);
            serviceCount++;

            // Update remove button visibility
            updateRemoveButtons();
        });

        // Remove service item
        function updateRemoveButtons() {
            const items = document.querySelectorAll('.service-item');
            items.forEach(item => {
                const removeBtn = item.querySelector('.btn-remove-service');
                if (items.length > 1) {
                    removeBtn.style.display = items[0] === item ? 'none' : 'block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
        }

        // Calculate total amount
        function calculateTotal() {
            let total = 0;
            const items = document.querySelectorAll('.service-item');
            
            items.forEach(item => {
                const select = item.querySelector('.service-select');
                const qty = parseInt(item.querySelector('.quantity-input').value) || 0;
                const price = parseInt(select.options[select.selectedIndex].getAttribute('data-price')) || 0;
                total += price * qty;
            });

            document.getElementById('totalAmount').textContent = '$' + total.toFixed(2);
        }

        // Add event listeners to first service item
        document.querySelector('.service-select').addEventListener('change', calculateTotal);
        document.querySelector('.quantity-input').addEventListener('change', calculateTotal);

        // Remove button functionality for first item (if already present)
        const firstRemoveBtn = document.querySelector('.btn-remove-service');
        if (firstRemoveBtn) {
            firstRemoveBtn.addEventListener('click', function() {
                document.querySelector('.service-item').remove();
                calculateTotal();
                updateRemoveButtons();
            });
        }

        // Initial update
        updateRemoveButtons();
    </script>
@endsection
