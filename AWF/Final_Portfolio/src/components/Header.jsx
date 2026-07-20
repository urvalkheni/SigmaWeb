import React from 'react';
import { Mail, Phone, MapPin } from 'lucide-react';

const Header = () => {
  return (
    <section id="home" className="header-section animate-fade-in">
      <h1 className="header-title">URVAL KHENI</h1>
      <h2 className="header-subtitle">Junior Penetration Tester | AI Security Red Teamer | Offensive & Defensive Cybersecurity</h2>
      
      <div style={{ display: 'flex', gap: '2rem', color: 'var(--text-color)', marginTop: '1rem', flexWrap: 'wrap', justifyContent: 'center' }}>
        <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
          <Mail size={18} color="var(--accent-color)" />
          <span>kheniurval777@gmail.com</span>
        </div>
        <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
          <Phone size={18} color="var(--accent-color)" />
          <span>+91 8238496254</span>
        </div>
        <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
          <MapPin size={18} color="var(--accent-color)" />
          <span>Gujarat, India</span>
        </div>
      </div>
    </section>
  );
};

export default Header;
