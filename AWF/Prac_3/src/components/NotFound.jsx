import React from 'react';
import { Link } from 'react-router-dom';

const NotFound = () => {
  return (
    <div className="glass-panel animate-fade-in" style={{ textAlign: 'center', padding: '4rem 2rem' }}>
      <h2 className="section-title" style={{ fontSize: '4rem', marginBottom: '1rem', color: 'var(--accent-color)' }}>404</h2>
      <h3>Page Not Found</h3>
      <p style={{ color: '#cbd5e1', marginBottom: '2rem' }}>The page you are looking for does not exist.</p>
      <Link 
        to="/" 
        style={{
          display: 'inline-block',
          padding: '0.75rem 1.5rem',
          background: 'var(--primary-color)',
          color: '#fff',
          borderRadius: '8px',
          fontWeight: 'bold'
        }}
      >
        Go Back Home
      </Link>
    </div>
  );
};

export default NotFound;
