import React from 'react';
import { GitPullRequest } from 'lucide-react';

const Contributions = () => {
  const contributions = [
    { id: 1, org: 'ns-3', name: 'tcp: Add tcp-bbr-example.py', date: '26 Jan 2026', link: '!2686', status: 'accepted' },
    { id: 2, org: 'ns-3', name: 'internet: fix off-by-one in ICMPv4 Print() formatting', date: '20 March 2026', link: '!2781', status: 'accepted' },
    { id: 3, org: 'ns-3', name: 'internet-apps: Fix duplicate Trace Complete output in V4TraceRoute', date: '19 May 2026', link: '!2815', status: 'accepted' },
    { id: 4, org: 'ns-3', name: 'Ping: Add handling for ICMPv4 Destination Unreachable...', date: 'pending', link: '!2820', status: 'pending' },
    { id: 5, org: 'ns-3', name: 'tcp: implement RFC 5961 challenge ACK handling...', date: 'pending', link: '!2853', status: 'pending' },
    { id: 6, org: 'wireshark', name: 'icmp: Add expert warning when code must be zero', date: '10 March 2026', link: '!23752', status: 'accepted' },
    { id: 7, org: 'wireshark', name: 'ICMP: add expert warnings for malformed extension object lengths', date: '6 April 2026', link: '!24175', status: 'accepted' },
    { id: 8, org: 'wireshark', name: 'HTTP: add expert warning for malformed response status code tokens', date: '22 April 2026', link: '!24178', status: 'accepted' },
    { id: 9, org: 'wireshark', name: 'adb: cap data_length and use lazy allocation', date: '19 June 2026', link: '!24469', status: 'accepted' },
    { id: 10, org: 'wireshark', name: 'http: fix UTF-8 handling in expert info for status code token', date: '23 April 2026', link: '!24554', status: 'accepted' },
    { id: 11, org: 'wireshark', name: 'http-urlencoded: fix percent-decoding bounds check', date: '20 June 2026', link: '!24570', status: 'accepted' },
    { id: 12, org: 'wireshark', name: 'dns: validate SVCB parameter lengths and resynchronize parsing', date: '18 May 2026', link: '!24942', status: 'accepted' },
    { id: 13, org: 'wireshark', name: 'dns: add semantic validation for SVCB parameters', date: '28 May 2026', link: '!25127', status: 'accepted' },
    { id: 14, org: 'wireshark', name: 'HTTP: Add expert warnings for malformed header syntax', date: '30 June 2026', link: '!25453', status: 'accepted' },
    { id: 15, org: 'wireshark', name: 'HTTP: add expert warning for whitespace in request-target', date: '16 July 2026', link: '!25595', status: 'accepted' },
    { id: 16, org: 'openssl', name: 'test: add all-alias BIGNUM coverage in file_sum', date: '8 July 2026', link: '#30893', status: 'accepted' },
    { id: 17, org: 'openssl', name: 'ssl: add optional external session ID collision callback', date: 'pending', link: '#30782', status: 'pending' },
    { id: 18, org: 'suricata', name: 'decode-tcp: fix unaligned access in TCP option parsing', date: '17 May 2026', link: '#15376', status: 'accepted' },
    { id: 19, org: 'suricata', name: 'output-json: avoid freeing caller-owned JSON builder', date: '11 June 2026', link: '#15599', status: 'accepted' },
    { id: 20, org: 'suricata', name: 'util: fix fallback memrchr() implementation', date: 'pending', link: '#15772', status: 'pending' },
    { id: 21, org: 'zeek', name: 'dns: validate LOC rdlength and enforce RR-local parsing', date: '28 April 2026', link: '#5357', status: 'accepted' },
    { id: 22, org: 'zeek', name: 'dns: reject malformed names and propagate label parse errors', date: '28 April 2026', link: '#5358', status: 'accepted' },
    { id: 23, org: 'zeek', name: 'dns: enforce RR-local bounds for EDNS option parsing', date: '5 May 2026', link: '#5359', status: 'accepted' },
    { id: 24, org: 'zeek', name: 'dns: validate SVCB minimum RDATA size using rdlength', date: '19 May 2026', link: '#5463', status: 'accepted' }
  ];

  const getUrl = (org, link) => {
    // Generate mock urls just for demonstration since actual URLs were not provided.
    // If it's a GitLab PR (!), or GitHub PR (#).
    if (link.startsWith('!')) {
      const num = link.slice(1);
      if (org === 'wireshark') return `https://gitlab.com/wireshark/wireshark/-/merge_requests/${num}`;
      if (org === 'ns-3') return `https://gitlab.com/nsnam/ns-3-dev/-/merge_requests/${num}`;
    }
    if (link.startsWith('#')) {
      const num = link.slice(1);
      if (org === 'zeek') return `https://github.com/zeek/zeek/pull/${num}`;
      if (org === 'suricata') return `https://github.com/OISF/suricata/pull/${num}`;
      if (org === 'openssl') return `https://github.com/openssl/openssl/pull/${num}`;
    }
    return '#';
  };

  return (
    <section id="contributions" className="animate-fade-in">
      <div style={{ display: 'flex', alignItems: 'center', gap: '1rem', justifyContent: 'center', marginBottom: '2rem' }}>
        <GitPullRequest size={36} color="var(--accent-color)" />
        <h2 className="section-title" style={{ margin: 0 }}>Open Source Contributions</h2>
      </div>

      <div className="glass-panel table-container">
        <table>
          <thead>
            <tr>
              <th>No.</th>
              <th>Organization</th>
              <th>Name</th>
              <th>Date</th>
              <th>Link / PR</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            {contributions.map((item) => (
              <tr key={item.id}>
                <td>{item.id}</td>
                <td style={{ fontWeight: 'bold' }}>{item.org}</td>
                <td>{item.name}</td>
                <td>{item.date}</td>
                <td>
                  <a href={getUrl(item.org, item.link)} target="_blank" rel="noreferrer">
                    {item.link}
                  </a>
                </td>
                <td>
                  <span className={`status-badge ${item.status === 'accepted' ? 'status-accepted' : 'status-pending'}`}>
                    {item.status.toUpperCase()}
                  </span>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </section>
  );
};

export default Contributions;
