import React, { useState, useEffect } from 'react';
import api from '../api';
import Swal from 'sweetalert2';
import { FaSpinner } from 'react-icons/fa';
import { useNavigate } from 'react-router-dom';

const ProductList = () => {
    const navigate = useNavigate();
    const [products, setProducts] = useState([]);
    const [error, setError] = useState('');
    const [loadingProductId, setLoadingProductId] = useState(null); 
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        const fetchProducts = async () => {
            try {
                const token = localStorage.getItem('token');
                const response = await api.get('/products', {
                    headers: { Authorization: `Bearer ${token}` },
                });
                setProducts(response.data);
                setIsLoading(false);
            } catch (err) {
                setError('Failed to fetch products.');
                setIsLoading(false);
            }
        };

        fetchProducts();
    }, []);

    const handlePushToShopify = async (productId) => {
        const token = localStorage.getItem('token');
        const result = await Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to push this product to Shopify?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, push it!',
            cancelButtonText: 'Cancel',
        });
        if (result.isConfirmed) {
            setLoadingProductId(productId);
            try {
                const result = await api.post(`/products/${productId}/push`, {}, { headers: { Authorization: `Bearer ${token}` } });
                if(result?.data?.errors){
                    Swal.fire({
                        title: 'Warning!',
                        text: result.data.errors + ' redirect to connection page.',
                        icon: 'warning',
                        confirmButtonText: 'OK',
                    });
                    navigate('/dashboard')
                    return
                }
                // setProducts(products.map((product) =>
                //     product.id === productId ? { ...product, is_pushed: true } : product
                // ));
                // Show success message using SweetAlert
                Swal.fire({
                    title: 'Success!',
                    text: 'Product pushed to Shopify!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                });
                setLoadingProductId(null);
            } catch (err) {
                setLoadingProductId(null);
                // Show error message using SweetAlert
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to push product to Shopify.',
                    icon: 'error',
                    confirmButtonText: 'Try Again',
                });
            }
        } else {
            // If the user canceled, show a cancellation message
            Swal.fire({
                title: 'Cancelled',
                text: 'The product was not pushed to Shopify.',
                icon: 'info',
                confirmButtonText: 'OK',
            });
        }
    };

    return (
        <div className="product-list-container">
            <h2 className="product-list-title">Products</h2>
            {isLoading && <div className="loading">Loading products...</div>}
            {error && <p className="error-message">{error}</p>}
            <div className="product-list">
                {products.map((product) => (
                    <div key={product.id} className="product-card">
                        <div className="product-image-container">
                            <img
                                src={product.image}
                                alt={product.name}
                                width="200"
                                height="200"
                            />
                        </div>
                        <h3 className="product-name">{product.name}</h3>
                        <p className="product-description">{product.description}</p>
                        <p className="product-price">Price: ${product.price}</p>
                        <button
                            className="push-button"
                            onClick={() => handlePushToShopify(product.id)}
                            // disabled={product.is_pushed || loadingProductId === product.id} // Disable if already pushed or if this product is being processed
                        >
                            {loadingProductId === product.id ? (
                                <FaSpinner className="spinner" />
                            ) : product.is_pushed ? (
                                'Already Pushed'
                            ) : (
                                'Push to Shopify'
                            )}
                        </button>
                    </div>
                ))}
            </div>
        </div>

    );
};

export default ProductList;
