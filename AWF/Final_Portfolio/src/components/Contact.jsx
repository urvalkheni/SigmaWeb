import React, { useState } from 'react';
import { Mail } from 'lucide-react';

const Contact = () => {
  const [message, setMessage] = useState('');

  return (
    <section id="contact" className="animate-fade-in" style={{ paddingBottom: '2rem' }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: '1rem', justifyContent: 'center', marginBottom: '2rem' }}>
        <Mail size={36} color="var(--accent-color)" />
        <h2 className="section-title" style={{ margin: 0 }}>Get In Touch</h2>
      </div>

      <div className="glass-panel" style={{ maxWidth: '600px', margin: '0 auto' }}>
        <p style={{ marginBottom: '1.5rem', color: '#cbd5e1', textAlign: 'center' }}>
          I am currently seeking Cybersecurity Internship roles in VAPT, SOC, AI Red Teaming, or Security Engineering. Feel free to reach out!
        </p>
        
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
            <span className="text-muted" style={{ fontSize: '0.9rem' }}>
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
      </div>
    </section>
  );
};

export default Contact;
