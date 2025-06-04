<template>
  <div class="terms-conditions">
    <div class="terms-header">
      <h1>Terms and Conditions</h1>
      <h2>Laboratory Booking and Equipment Reservation System (LABERS)</h2>
      <h3>Gordon College – College of Computer Studies</h3>
    </div>

    <div class="terms-content">
      <section class="term-section">
        <h4>1. Purpose</h4>
        <p>
          LABERS is developed to streamline laboratory and equipment reservations within the College of Computer Studies (CCS). 
          It addresses scheduling conflicts, resource allocation, and usage tracking by offering a centralized, automated platform 
          for head students and faculty.
        </p>
      </section>

      <section class="term-section">
        <h4>2. User Responsibilities</h4>
        <p>Users agree to:</p>
        <ul>
          <li>Use the system solely for official academic and institutional purposes.</li>
          <li>Provide accurate and updated personal and booking information.</li>
          <li>Respect approved reservations and avoid misuse of laboratory or equipment resources.</li>
          <li>Report any system misuse, technical issues, or policy violations.</li>
        </ul>
      </section>

      <section class="term-section">
        <h4>3. Data Privacy</h4>
        <p>
          LABERS collects and processes personal data such as names, domain emails, and position, as required for scheduling 
          and usage tracking. Data processing follows the Gordon College Privacy Policy and the Data Privacy Act of 2012. 
          For more, refer to: <a href="#" class="policy-link">GC General Privacy Notice</a>.
        </p>
      </section>

      <section class="term-section">
        <h4>4. Data Use and Storage</h4>
        <p>Personal data is stored in secured digital systems under the developers' control. Data may be used to:</p>
        <ul>
          <li>Manage and track reservations.</li>
          <li>Generate reports for academic planning.</li>
          <li>Ensure compliance with college policies.</li>
        </ul>
      </section>

      <section class="term-section">
        <h4>5. Rights of Users</h4>
        <p>In accordance with Gordon College's Data Privacy Policy, users have the right to:</p>
        <ul>
          <li>Be informed of data processing activities;</li>
          <li>Access, correct, or request deletion of personal data (when applicable);</li>
          <li>Object to data processing, subject to institutional limitations.</li>
        </ul>
      </section>

      <section class="term-section">
        <h4>6. Limitation of Liability</h4>
        <p>
          Gordon College shall not be held liable for incidental damages caused by system errors or service interruptions 
          due to compliance with its legal and academic obligations.
        </p>
      </section>

      <section class="term-section">
        <h4>7. Policy Amendments</h4>
        <p>
          These Terms may be updated without prior notice. Continued use of LABERS implies acceptance of current policies.
        </p>
      </section>

      <section class="term-section">
        <h4>8. Contact Information</h4>
        <p>For questions or concerns regarding data privacy:</p>
        
        <div class="contact-info">
          <div class="contact-block">
            <h5>LABERS Office</h5>
            <p>
              Olongapo City Sports Complex, Donor St., East Tapinac, Olongapo City 2200<br>
              Phone: <a href="tel:0915-743-9434">0915-743-9434</a><br>
              Email: <a href="mailto:laberssystem@gmail.com">laberssystem@gmail.com</a>
            </p>
          </div>

          <div class="contact-block">
            <h5>Gordon College Data Privacy Office</h5>
            <p>
              Olongapo City Sports Complex, Donor St., East Tapinac, Olongapo City 2200<br>
              Phone: <a href="tel:(047)222-4080">(047) 222-4080</a><br>
              Email: <a href="mailto:dpo@gordoncollege.edu.ph">dpo@gordoncollege.edu.ph</a>
            </p>
          </div>
        </div>
      </section>
    </div>

    <div class="terms-footer" v-if="showAcceptButton">
      <button 
        @click="handleAccept" 
        class="accept-button"
        :disabled="!canAccept"
      >
        {{ acceptButtonText }}
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LabersTermsConditions',
  props: {
    showAcceptButton: {
      type: Boolean,
      default: false
    },
    acceptButtonText: {
      type: String,
      default: 'I Accept'
    },
    canAccept: {
      type: Boolean,
      default: true
    }
  },
  emits: ['accept'],
  methods: {
    handleAccept() {
      this.$emit('accept');
    }
  }
}
</script>

<style scoped>
.terms-conditions {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  line-height: 1.6;
  color: #333;
}

.terms-header {
  text-align: center;
  margin-bottom: 30px;
  padding-bottom: 20px;
  border-bottom: 2px solid #e0e0e0;
}

.terms-header h1 {
  color: #2c3e50;
  font-size: 2.2em;
  margin-bottom: 10px;
}

.terms-header h2 {
  color: #34495e;
  font-size: 1.5em;
  margin-bottom: 5px;
  font-weight: 600;
}

.terms-header h3 {
  color: #7f8c8d;
  font-size: 1.2em;
  font-weight: 400;
}

.terms-content {
  margin-bottom: 30px;
}

.term-section {
  margin-bottom: 25px;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 8px;
  border-left: 4px solid #3498db;
}

.term-section h4 {
  color: #2c3e50;
  font-size: 1.3em;
  margin-bottom: 15px;
  font-weight: 600;
}

.term-section h5 {
  color: #34495e;
  font-size: 1.1em;
  margin-bottom: 10px;
  font-weight: 600;
}

.term-section p {
  margin-bottom: 10px;
  text-align: justify;
}

.term-section ul {
  margin-left: 20px;
  margin-bottom: 10px;
}

.term-section li {
  margin-bottom: 8px;
}

.policy-link {
  color: #3498db;
  text-decoration: none;
}

.policy-link:hover {
  text-decoration: underline;
}

.contact-info {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-top: 15px;
}

.contact-block {
  background-color: #ffffff;
  padding: 15px;
  border-radius: 6px;
  border: 1px solid #e0e0e0;
}

.contact-block h5 {
  color: #2c3e50;
  margin-bottom: 10px;
  font-size: 1em;
}

.contact-block a {
  color: #3498db;
  text-decoration: none;
}

.contact-block a:hover {
  text-decoration: underline;
}

.terms-footer {
  text-align: center;
  padding-top: 20px;
  border-top: 2px solid #e0e0e0;
}

.accept-button {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 12px 30px;
  font-size: 1.1em;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.accept-button:hover:not(:disabled) {
  background-color: #2980b9;
}

.accept-button:disabled {
  background-color: #bdc3c7;
  cursor: not-allowed;
}

@media (max-width: 768px) {
  .terms-conditions {
    padding: 15px;
  }
  
  .terms-header h1 {
    font-size: 1.8em;
  }
  
  .terms-header h2 {
    font-size: 1.3em;
  }
  
  .contact-info {
    grid-template-columns: 1fr;
  }
  
  .term-section {
    padding: 15px;
  }
}
</style>