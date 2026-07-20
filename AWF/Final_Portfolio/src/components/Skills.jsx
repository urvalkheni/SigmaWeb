import React from 'react';
import { Award } from 'lucide-react';

const Skills = () => {
  const skillCategories = [
    {
      title: 'Security & Analysis',
      skills: ['Vulnerability Analysis', 'Attack Surface Analysis', 'Threat Modeling', 'Network Forensics', 'Detection Engineering', 'Incident Triage']
    },
    {
      title: 'Offensive',
      skills: ['VAPT', 'Web Security (SQLi, XSS, CSRF, SSRF)', 'Privilege Escalation', 'Exploitation', 'Payload Crafting']
    },
    {
      title: 'Defensive',
      skills: ['SOC Analysis', 'SIEM (Splunk)', 'Log Analysis']
    },
    {
      title: 'Tools',
      skills: ['Wireshark', 'Burp Suite', 'Nmap', 'Metasploit', 'tcpdump', 'ffuf', 'Zeek']
    },
    {
      title: 'Programming & DB',
      skills: ['Python', 'C', 'C++', 'Bash', 'SQL']
    },
    {
      title: 'Platforms',
      skills: ['Linux (Kali, Ubuntu)']
    }
  ];

  return (
    <section id="skills" className="animate-fade-in">
      <div style={{ display: 'flex', alignItems: 'center', gap: '1rem', justifyContent: 'center', marginBottom: '2rem' }}>
        <Award size={36} color="var(--accent-color)" />
        <h2 className="section-title" style={{ margin: 0 }}>Skills & Technologies</h2>
      </div>

      <div className="grid-2">
        {skillCategories.map((cat, idx) => (
          <div key={idx} className="glass-panel skill-category" style={{ padding: '2rem' }}>
            <h3>{cat.title}</h3>
            <div className="skill-list">
              {cat.skills.map((skill, i) => (
                <span key={i} className="skill-item">{skill}</span>
              ))}
            </div>
          </div>
        ))}
      </div>
    </section>
  );
};

export default Skills;
