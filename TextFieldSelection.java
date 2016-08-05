import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;

public class Exer14 extends JFrame {
	private String[] modes = {"SINGLE_SELECTION", "SINGLE_INTERVAL_SELECTION",
			"MULTIPLE_INTERVAL_SELECTION"};
	private JLabel jlblSelectionMode = new JLabel("Choose Selection Mode");
	private JComboBox jcbMode = new JComboBox(modes);
	private String[] countries = {"United States", "United Kingdom",
			"China", "Germany", "France"};
	private JList jlstCountries = new JList(countries);
	private JLabel jlblShow = new JLabel("");

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		Exer14 frame = new Exer14();
		frame.setTitle("Demonstrate JComboBox and JList");
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		frame.setLocationRelativeTo(null);
		frame.setVisible(true);
		frame.pack();

	}
	
	public Exer14() {
		JPanel controlPanel = new JPanel(new FlowLayout());
		controlPanel.add(jlblSelectionMode);
		controlPanel.add(jcbMode);
		
		JPanel selectionPanel = new JPanel();
		jlstCountries.setSize(new Dimension(400, 300));
		jlstCountries.setSelectionMode(0);
		selectionPanel.add(jlstCountries, null);
		
		JPanel displayPanel = new JPanel();
		displayPanel.add(jlblShow);
		
		add(controlPanel, BorderLayout.NORTH);
		add(new JScrollPane(selectionPanel), BorderLayout.CENTER);
		add(displayPanel, BorderLayout.SOUTH);
		
		jlstCountries.addListSelectionListener(new ListSelectionListener() {
			@Override
			public void valueChanged(ListSelectionEvent e) {
				multipleSelection();
			}
		});
		
		jcbMode.addItemListener(new ItemListener() {
			@Override
			public void itemStateChanged(ItemEvent e) {
				System.out.println(jlstCountries.getSelectionMode());
				
				if (jcbMode.getSelectedIndex() == 0) {
					jlstCountries.setSelectionMode(0);
				}
				else if (jcbMode.getSelectedIndex() == 1){
					jlstCountries.setSelectionMode(1);
				}
				else
					jlstCountries.setSelectionMode(2);
			}
		});
	}
	
	public void multipleSelection() {
		int[] indices = jlstCountries.getSelectedIndices();
		StringBuilder string = new StringBuilder();
		for (int i = 0; i < indices.length; i++) {
			
			string.append(countries[indices[i]] + " ");
		}
		
		jlblShow.setText(string.toString());
	}

}
