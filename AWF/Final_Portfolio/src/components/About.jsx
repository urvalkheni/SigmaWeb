import React from 'react';
import { Target } from 'lucide-react';

const About = () => {
  return (
    <section id="about" className="glass-panel animate-fade-in" style={{ padding: '3rem' }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: '1rem', marginBottom: '1.5rem' }}>
        <Target size={32} color="var(--accent-color)" />
        <h2 style={{ margin: 0, fontSize: '2rem' }}>Summary</h2>
      </div>
      <p style={{ fontSize: '1.1rem', color: '#cbd5e1' }}>
        Junior penetration tester and AI security red teamer focused on protocol analysis, vulnerability detection, and network-level debugging, with expertise in attack surface analysis and threat modeling. Contributed 19 accepted patches to Wireshark, ns-3, Zeek, OpenSSL, and Suricata, improving RFC-compliant, memory-safe behavior in production systems. Combines offensive experience (100+ labs: SQLi, XSS, CSRF, SSRF, privilege escalation) with defensive skills in SOC workflows, detection engineering, and incident triage. Skilled in root cause analysis and network forensics. Seeking Cybersecurity Internship roles in VAPT, SOC, AI Red Teaming, or Security Engineering.
      </p>
    </section>
  );
};

export default About;
