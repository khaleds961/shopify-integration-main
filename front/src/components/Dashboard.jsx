import React, { useState } from 'react';
import api from '../api';
import { FaShopify } from 'react-icons/fa';
import { ImSpinner8 } from 'react-icons/im';
import { useNavigate } from 'react-router-dom';
import Swal from 'sweetalert2';

const Dashboard = () => {

    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(false);
    const [siteError, setSiteError] = useState(false);
    const [shop, setShop] = useState('');

    const navigate = useNavigate();
    let intervalId;

    const handleConnectShopify = async () => {

        const token = localStorage.getItem('token');
        
        intervalId = setInterval(() => {
            checkUser(token);
        }, 1000);

        if (!shop) {
            setError(true)
            return
        }
        if (!token) {
            console.error('No token found in local storage');
            return;
        }
        setIsLoading(true);

        window.open(
            `http://127.0.0.1:8000/api/shopify/redirect?token=${encodeURIComponent(token)}&shop=${shop}`,
            '_blank', // Open in a new tab or window
            'width=800,height=600'
        );
    };

    const checkUser = async (token) => {
        try {
            console.log('Checking user access...');

            const response = await api.get('/userAccess', {
                headers: { Authorization: `Bearer ${token}` },
            });

            if (response.data.success) {
                setIsLoading(false);
                navigate('/products');
                clearInterval(intervalId);
                // Swal.fire({
                //     title: 'Success',
                //     text: 'You are now connected to Shopify. You will be redirected to the products page.',
                //     icon: 'success',
                //     confirmButtonText: 'OK'
                // }).then(() => {
                //     setIsLoading(false);
                //     navigate('/products');
                //     clearInterval(intervalId);
                // });
            } else {
                setSiteError(true)
                setIsLoading(false);
            }
        } catch (err) {
            console.log(err);
        }
    }

    return (
        <div className="dashboard-container">
            <h3>Please enter your Shopify shop:</h3>
            <input type="text" placeholder="ex: dexter-clothes.myshopify.com" className="shopify-input"
                onChange={(e) => setShop(e.target.value)}
            />
            <button className="shopify-button" onClick={handleConnectShopify} disabled={isLoading}>
                {isLoading ? (
                    <ImSpinner8 className="spinner-icon" />
                ) : (
                    <FaShopify className="shopify-icon" />
                )}
                {isLoading ? 'Connecting...' : 'Connect to Shopify'}
            </button>
            {error ? <p className='error-p'>Please enter your Shopify shop</p> : ''}
            {siteError ? <p className='error-p'>The URL you entered may be incorrect.</p> : ''}
        </div>
    );
};

export default Dashboard;