import React from 'react';
import { useNavigate } from 'react-router-dom';

const Navbar = () => {
    const navigate = useNavigate();

    const handleLogout = async () => {
        try {
            localStorage.removeItem('token');
            navigate('/login');
        } catch (error) {
            console.error('Logout failed:', error);
        }
    };

    return (
        <nav className='logout'>
            {localStorage.getItem('token') ?
                <button onClick={handleLogout}>Logout</button>
                : null}
        </nav>
    );
};

export default Navbar;