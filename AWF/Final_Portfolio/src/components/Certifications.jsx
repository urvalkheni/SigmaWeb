import React from 'react';
import { CheckCircle } from 'lucide-react';

const Certifications = () => {
  const certs = [
    { title: 'CCNA: Introduction to Networks', issuer: 'Cisco', date: 'Apr 2026' },
    { title: 'Ranked #1 of 100 Global Winners', issuer: 'TryHackMe AI Security (AI1) Certification Program (2,000+ participants)' },
    { title: 'Certified: Advanced SQLite Queries', issuer: 'Belkasoft (Digital Forensics)' },
    { title: 'NPTEL: Ethical Hacking', issuer: 'NPTEL' },
    { title: 'Pre Security, Advent of Cyber 2025', issuer: 'TryHackMe' },
    { title: 'Top 15 teams', issuer: "HackOut'25 (1000+ teams)" },
    { title: 'Top 25 teams', issuer: "Hackdata CTF'26 (Shiv Nadar University)" },
  ];

  return (
    <section id="certifications" className="animate-fade-in">
      <div style={{ display: 'flex', alignItems: 'center', gap: '1rem', justifyContent: 'center', marginBottom: '2rem' }}>
        <CheckCircle size={36} color="var(--accent-color)" />
        <h2 className="section-title" style={{ margin: 0 }}>Certifications & Achievements</h2>
      </div>

      <div className="grid-2">
        {certs.map((cert, idx) => (
          <div key={idx} className="glass-panel" style={{ padding: '1.5rem', display: 'flex', flexDirection: 'column', justifyContent: 'center' }}>
            <h3 style={{ fontSize: '1.2rem', marginBottom: '0.5rem' }}>{cert.title}</h3>
            <p className="text-muted" style={{ margin: 0 }}>
              {cert.issuer} {cert.date && <span>| {cert.date}</span>}
            </p>
          </div>
        ))}
      </div>
    </section>
  );
};

export default Certifications;
