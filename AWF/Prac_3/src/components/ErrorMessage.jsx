import React from 'react';

const ErrorMessage = ({ message, onRetry }) => {
  return (
    <div className="glass-panel" style={{ textAlign: 'center', padding: '2rem', borderColor: '#ef4444' }}>
      <h3 style={{ color: '#ef4444', marginBottom: '1rem' }}>Something went wrong!</h3>
      <p style={{ color: '#cbd5e1', marginBottom: '1.5rem' }}>{message}</p>
      {onRetry && (
        <button 
          onClick={onRetry}
          style={{
            padding: '0.5rem 1rem',
            background: '#ef4444',
            color: '#fff',
            border: 'none',
            borderRadius: '8px',
            cursor: 'pointer',
            fontWeight: 'bold'
          }}
        >
          Try Again
        </button>
      )}
    </div>
  );
};

export default ErrorMessage;
