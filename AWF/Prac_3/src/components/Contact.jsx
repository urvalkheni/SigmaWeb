import React, { useState } from 'react';

const Contact = () => {
  const [message, setMessage] = useState('');

  return (
    <section className="glass-panel animate-fade-in" style={{ maxWidth: '600px', margin: '0 auto' }}>
      <h2 className="section-title">Contact Me</h2>
      <p style={{ marginBottom: '1rem', color: '#cbd5e1' }}>Leave a message below:</p>
      
      <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
        <textarea 
          value={message} 
          onChange={(e) => setMessage(e.target.value)} 
          placeholder="Type your message here..."
          rows="5"
          style={{
            padding: '1rem',
            borderRadius: '8px',
            background: 'rgba(255,255,255,0.05)',
            border: '1px solid var(--border-color)',
            color: 'var(--text-color)',
            fontFamily: 'inherit',
            fontSize: '1rem',
            resize: 'vertical'
          }}
        />
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
          <span style={{ fontSize: '0.9rem', color: '#94a3b8' }}>
            Character count: {message.length}
          </span>
          <button 
            disabled={message.length === 0}
            style={{
              padding: '0.75rem 1.5rem',
              borderRadius: '8px',
              background: 'var(--primary-color)',
              color: '#fff',
              border: 'none',
              cursor: message.length === 0 ? 'not-allowed' : 'pointer',
              fontWeight: 'bold',
              opacity: message.length === 0 ? 0.5 : 1
            }}
          >
            Send Message
          </button>
        </div>
      </div>
    </section>
  );
};

export default Contact;
