
import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import api from '../api';
import { ImSpinner8 } from 'react-icons/im';
import '../App.css'

const Login = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            const response = await api.post('/login', { email, password });
            localStorage.setItem('token', response.data.access_token);
            navigate('/dashboard');
            setLoading(false);
        } catch (err) {
            setLoading(false);
            setError('Invalid email or password.');
        }
    };

    return (
        <div className="login-container">
            <h2>Login</h2>
            {error && <p className="error-message">{error}</p>}
            <form onSubmit={handleSubmit} className="login-form">
                <input
                    type="email"
                    placeholder="Email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                />
                <input
                    type="password"
                    placeholder="Password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                />
                <button type="submit" className="login-button">
                    {loading ?
                        <ImSpinner8 className="spinner-icon" />
                        : 'Login'}
                </button>
            </form>
        </div>
    );
};

export default Login;