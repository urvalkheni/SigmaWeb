import React from 'react';
import { Briefcase } from 'lucide-react';

const Experience = () => {
  return (
    <section id="experience" className="animate-fade-in">
      <div style={{ display: 'flex', alignItems: 'center', gap: '1rem', justifyContent: 'center', marginBottom: '2rem' }}>
        <Briefcase size={36} color="var(--accent-color)" />
        <h2 className="section-title" style={{ margin: 0 }}>Experience</h2>
      </div>

      <div style={{ display: 'flex', flexDirection: 'column', gap: '2rem' }}>
        {/* Open Source */}
        <div className="glass-panel" style={{ position: 'relative' }}>
          <div style={{ position: 'absolute', top: '2rem', right: '2rem', color: 'var(--accent-color)', fontWeight: 'bold' }}>
            Nov 2025 – Present
          </div>
          <h3 style={{ fontSize: '1.5rem', marginBottom: '0.5rem' }}>Open-Source Contributor</h3>
          <h4 className="text-muted" style={{ marginBottom: '1.5rem' }}>Wireshark, ns-3, Zeek, OpenSSL, Suricata</h4>
          
          <ul style={{ listStyleType: 'disc', paddingLeft: '1.5rem', color: '#cbd5e1', display: 'flex', flexDirection: 'column', gap: '0.5rem' }}>
            <li>Delivered 19 accepted patches addressing low-level protocol parsing and boundary-handling issues, improving RFC compliance and memory safety in production network stacks.</li>
            <li>Introduced expert warnings and strict validation logic to detect malformed traffic, enhancing protocol correctness, security visibility, and analysis reliability.</li>
            <li><strong>MRs/PRs:</strong> Wireshark:(!23752, !24175, !24178, !24469, !24554, !24570, !24942, !25127, !25453) | ns-3:(!2686, !2781, !2815) | Zeek:(#5357, #5358, #5359, #5463) | OpenSSL:(#30893) | Suricata:(#15376, #15599)</li>
          </ul>
        </div>

        {/* Coordinator */}
        <div className="glass-panel" style={{ position: 'relative' }}>
          <div style={{ position: 'absolute', top: '2rem', right: '2rem', color: 'var(--accent-color)', fontWeight: 'bold' }}>
            Nov 2025 – Mar 2026
          </div>
          <h3 style={{ fontSize: '1.5rem', marginBottom: '0.5rem' }}>Coordinator</h3>
          <h4 className="text-muted" style={{ marginBottom: '1.5rem' }}>Xcoder Squad</h4>
          
          <ul style={{ listStyleType: 'disc', paddingLeft: '1.5rem', color: '#cbd5e1' }}>
            <li>Coordinated technical events (C-TITANS, SUPERNOVA), designed C/C++ problem sets, and supported platform testing, strengthening leadership and execution in team environments.</li>
          </ul>
        </div>
      </div>
    </section>
  );
};

export default Experience;
